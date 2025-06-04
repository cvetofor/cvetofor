<?php

namespace App\Listeners;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\LongLivedAccessToken;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\TagsCollection;
use AmoCRM\Exceptions\AmoCRMApiErrorResponseException;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMApiNoContentException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Exceptions\InvalidArgumentException;
use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\SelectCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\SelectCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\SelectCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\TagModel;
use App;
use App\Events\OrderAmocrmUpdate;
use App\Models\Color;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\ProductPrice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\Types\Collection;

class OrderUpdatedCrmListener implements ShouldQueue
{
    use InteractsWithQueue;

    private AmoCRMApiClient $client;

    private string $prefix = 'amocrm.opt03';

    /**
     * @throws AmoCRMoAuthApiException
     * @throws InvalidArgumentException
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     */
    public function handle(OrderAmocrmUpdate $event): void
    {
        $amocrmLogger = logger()->channel('amocrm');
        $amocrmLogger->debug('Начали обработку заказа', ['order_id' => $event->order->id]);
        if (App::isLocal()) {
            $this->prefix = 'amocrm.testfloweramocrmru';
        }

        $this->client = (new AmoCRMApiClient)
            ->setAccountBaseDomain(config("$this->prefix.domain"))
            ->setAccessToken((new LongLivedAccessToken(config("$this->prefix.token"))));

        $order = $event->order;
        $childOrderMarketIds = $order->childs->pluck('market_id');
        if ($order->market_id != 1 && ! in_array(1, $childOrderMarketIds->toArray())) {
            $amocrmLogger->debug('Закончили обработку заказа. Заказ привязан не к магазину Цветофор Улан-Удэ');

            return;
        } // Заказ привязан не к магазину Цветофор Улан-Удэ

        if ($order->paymentStatus->title == 'Оплачено') {
            $amocrmLogger->debug('Начали поиск сделки', ['query' => "Заказ #$order->num_order"]);
            $lead = $this->findLead("Заказ #$order->num_order");
            if (empty($lead)) {
                $amocrmLogger->warning('Не смогли найти сделку в системе');
                return;
            }

            $amocrmLogger->debug('Нашли сделку', ['lead_id' => $lead->getId()]);

            $leadModel = $this->makeLeadModel($order, $lead->getId());
            try {
                $this->client->leads()->updateOne($leadModel);
                $amocrmLogger->debug('Обновили сделку');
            } catch (AmoCRMApiErrorResponseException $e) {
                $amocrmLogger->error('Произошла ошибка при попытке обновления сделки', [
                    'message' => $e->getMessage(),
                    'request' => Arr::except($e->getLastRequestInfo(), ['curl_call', 'jquery_call']),
                ]);

                return;
            }
        } else {
            $amocrmLogger->debug('Статус оплаты: '.$order->paymentStatus->title);
        }
    }

    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     */
    private function findLead(string $name): ?LeadModel
    {
        try {
            $leadsFilter = (new LeadsFilter)->setQuery($name);

            $leads = $this->client->leads()->get($leadsFilter);
        } catch (AmoCRMApiNoContentException) {
            return null;
        }


        return collect($leads->getIterator())
            ->first(fn(LeadModel $lead) => $lead->getName() === $name);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function makeLeadModel(Order $order, int $leadId): LeadModel
    {
        return (new LeadModel)
            ->setId($leadId)
            ->setTags($this->makeTagsCollection($order, $leadId))
            ->setCustomFieldsValues($this->makeLeadCustomFields($order));
    }

    protected function makeTagsCollection(Order $order, int $leadId): TagsCollection
    {
        $tagsCollection = $this->client->leads()->getOne($leadId)->getTags() ?? new TagsCollection;

        if ($order->paymentStatus->title == 'Оплачено') {
            $tagsCollection->add((new TagModel)->setName('Оплачено'));
        }

        return $tagsCollection;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function makeLeadCustomFields(Order $order): CustomFieldsValuesCollection
    {
        $cf = new CustomFieldsValuesCollection;

        // Работа с полями требующими приведения или строгих типов
        $cf->add((new SelectCustomFieldValuesModel)
            ->setFieldId(config("$this->prefix.cf.payment_status"))
            ->setValues((new SelectCustomFieldValueCollection)
                ->add((new SelectCustomFieldValueModel)
                    ->setValue($order->paymentStatus->title == 'Оплачено' ? 'Оплачен' : 'НЕ ОПЛАЧЕН'))));

        $paymentMethodId = config("$this->prefix.cf.payment_method_map.{$order->payment->code}");
        $cf->add((new SelectCustomFieldValuesModel)
            ->setFieldId(config("$this->prefix.cf.payment_method"))
            ->setValues((new SelectCustomFieldValueCollection)
                ->add((new SelectCustomFieldValueModel)->setEnumId($paymentMethodId))));

        return $cf;
    }

    protected function getDeliveryPrice(Order $order): mixed
    {
        $deliveryOrderPrice = Delivery::where('order_id', $order->id)->first();

        return $deliveryOrderPrice && isset($deliveryOrderPrice->price) ? $deliveryOrderPrice->price : 0;
    }

    protected function makeAdminOrderUrl(Order $order): string
    {
        return ! empty($order->parent_id)
            ? "https://цветофор.рф/hub/orders/$order->id/edit"
            : '';
    }

    protected function makeDeliveryAddressValue(Order $order): string
    {
        return ! empty($order->address)
            ? implode(', ', array_filter(array_merge(
                (array) str_replace('Республика Бурятия, ', '', data_get($order->address, 'address')),
                ! empty(data_get($order->address, 'apartament_number')) ? [data_get($order->address, 'apartament_number')] : [],
            )))
            : 'Уточнить у получателя';
    }

    protected function extractProductsInformation(Order $order): array
    {
        $cartItems = $order->cart;
        $orderStructure = '';
        $receipt = '';
        $lastIndex = count($cartItems) - 1;
        $currentIndex = 0;
        $packaging = 0;

        if (! empty($cartItems)) {
            foreach ($cartItems as $cartItem) {
                $bouquetName = data_get($cartItem, 'name');
                $bouquetQuantity = data_get($cartItem, 'quantity');
                $orderStructure .= "\n$bouquetName x$bouquetQuantity\n";
                $receipt .= "$bouquetName x$bouquetQuantity";

                if ($currentIndex < $lastIndex) {
                    $receipt .= ', ';
                }
                $currentIndex++;

                if (data_get($cartItem, 'attributes.composition') !== null) {
                    foreach (data_get($cartItem, 'attributes.composition') as $componentBouquet) {
                        $bouquetTitle = data_get($componentBouquet, 'title');
                        $bouquetColorId = data_get($componentBouquet, 'color');
                        $bouquetColor = Color::find($bouquetColorId);
                        $componentProduct = data_get($componentBouquet, 'product');
                        $componentBouquetCount = data_get($componentBouquet, 'count');

                        $orderStructure .= "- $bouquetTitle: ".trim(($componentBouquetCount ?: '').($componentBouquetCount && $bouquetColor?->title ? ', ' : '').($bouquetColor?->title ?: ''))."\n";
                        if (preg_match('/^Упаковка\.?$|^Упаковка \/ [\p{L}]+$/u', $bouquetTitle)) {
                            $packagingPrice = ProductPrice::where('product_id', $componentProduct)->first();
                            $packaging = ($packagingPrice && $packagingPrice->price)
                                ? $componentBouquetCount * $packagingPrice->price
                                : $componentBouquetCount;

                        }
                    }
                }
            }
        }

        return [$orderStructure, $receipt, $packaging];
    }

    /**
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     */
    private function createContact(Order $order): ContactModel
    {
        return $this->client->contacts()->addOne((new ContactModel)
            ->setName($order->user->last_name.' '.$order->user->name.' '.$order->user->second_name)
            ->setCustomFieldsValues($this->makeContactCustomFields($order)));
    }

    protected function makeContactCustomFields(Order $order): CustomFieldsValuesCollection
    {
        return (new CustomFieldsValuesCollection)
            ->add((new MultitextCustomFieldValuesModel)
                ->setFieldCode('PHONE')
                ->setValues((new MultitextCustomFieldValueCollection)
                    ->add((new MultitextCustomFieldValueModel)->setValue("$order->phone")),
                ),
            );
    }
}
