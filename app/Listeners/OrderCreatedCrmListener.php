<?php

namespace App\Listeners;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\LongLivedAccessToken;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Collections\TagsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMApiNoContentException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Exceptions\InvalidArgumentException;
use AmoCRM\Filters\ContactsFilter;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\DateCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\MultitextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\NumericCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\SelectCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\TextareaCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\UrlCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\DateCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\MultitextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\NumericCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\SelectCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextareaCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\UrlCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\DateCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\MultitextCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\NumericCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\SelectCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextareaCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\UrlCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\TagModel;
use App;
use App\Events\OrderCreated;
use App\Models\Color;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\ProductPrice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreatedCrmListener implements ShouldQueue
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
    public function handle(OrderCreated $event): void
    {
        if (App::isLocal()) $this->prefix = 'amocrm.testfloweramocrmru';

        $this->client = (new AmoCRMApiClient())
            ->setAccountBaseDomain(config("$this->prefix.domain"))
            ->setAccessToken((new LongLivedAccessToken(config("$this->prefix.token"))));

        $order = $event->order;
        if ($order->market_id != 1) return; // Заказ привязан не к магазину Цветофор Улан-Удэ


        $contact = $this->findContact($order->phone);
        if (empty($contact)) $contact = $this->createContact($order);

        $deliveryPrice = $this->getDeliveryPrice($order);
        $leadModel = $this->makeLeadModel($order, $deliveryPrice);

        $this->client->leads()->addOne($leadModel);
        $this->client->leads()->link($leadModel, (new LinksCollection())->add($contact));
    }

    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     */
    private function findContact(string $phone): ?ContactModel
    {
        try {
            $contactsFilter = (new ContactsFilter())
                ->setQuery($phone);

            $contacts = $this->client->contacts()
                ->get($contactsFilter);
        } catch (AmoCRMApiNoContentException) {
            return null;
        }

        return $contacts->first();

    }

    /**
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     */
    private function createContact(Order $order): ContactModel
    {
        return $this->client->contacts()->addOne((new ContactModel())
            ->setName($order->user->last_name . ' ' . $order->user->name . ' ' . $order->user->second_name)
            ->setCustomFieldsValues($this->makeContactCustomFields($order)));
    }

    protected function makeContactCustomFields(Order $order): CustomFieldsValuesCollection
    {
        return (new CustomFieldsValuesCollection())
            ->add((new MultitextCustomFieldValuesModel())
                ->setFieldCode('PHONE')
                ->setValues((new MultitextCustomFieldValueCollection())
                    ->add((new MultitextCustomFieldValueModel())->setValue("$order->phone")),
                ),
            );
    }

    protected function getDeliveryPrice(Order $order): mixed
    {
        $deliveryOrderPrice = Delivery::where('order_id', $order->id)->first();
        return $deliveryOrderPrice && isset($deliveryOrderPrice->price) ? $deliveryOrderPrice->price : 0;
    }

    protected function makeLeadModel(Order $order, mixed $deliveryPrice): LeadModel
    {
        return (new LeadModel())
            ->setName("Заказ #$order->id")
            ->setPrice($order->total_price + $deliveryPrice)
            ->setPipelineId(config('amocrm.pipeline_id'))
            ->setStatusId(config("$this->prefix.status_id"))
            ->setTags($this->makeTagsCollection($order))
            ->setCustomFieldsValues($this->makeLeadCustomFields($order, $deliveryPrice));
    }

    protected function makeTagsCollection(Order $order): TagsCollection
    {
        $tagsCollection = (new TagsCollection())
            ->add((new TagModel())->setName('Сайт'))
            ->add((new TagModel())->setName('Доставка'));

        if ($order->paymentStatus->title == 'Оплачено') {
            $tagsCollection->add((new TagModel())->setName('Оплачено'));
        }

        return $tagsCollection;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function makeLeadCustomFields(Order $order, mixed $deliveryPrice): CustomFieldsValuesCollection
    {
        $cf = new CustomFieldsValuesCollection();

        // Работа с полями требующими приведения или строгих типов
        $cf->add((new SelectCustomFieldValuesModel())
            ->setFieldId(config("$this->prefix.cf.payment_status"))
            ->setValues((new SelectCustomFieldValueCollection())
                ->add((new SelectCustomFieldValueModel())
                    ->setValue($order->paymentStatus->title == 'Оплачено' ? 'Оплачен' : 'НЕ ОПЛАЧЕН'))));

        $cf->add((new UrlCustomFieldValuesModel())
            ->setFieldId(config("$this->prefix.cf.order_link"))
            ->setValues((new UrlCustomFieldValueCollection())
                ->add((new UrlCustomFieldValueModel())->setValue($this->makeAdminOrderUrl($order)))));

        $cf->add((new NumericCustomFieldValuesModel())
            ->setFieldId(config("$this->prefix.cf.delivery_cost"))
            ->setValues((new NumericCustomFieldValueCollection())
                ->add((new NumericCustomFieldValueModel())->setValue($deliveryPrice))));

        $fields = [
            config("$this->prefix.cf.receiving_name") => $order->person_receiving_name,
            config("$this->prefix.cf.delivery_interval") => $order->delivery_time,
            config("$this->prefix.cf.delivery_address") => $this->makeDeliveryAddressValue($order),
            config("$this->prefix.cf.receiving_phone") => $order->person_receiving_phone ?? '',
            config("$this->prefix.cf.delivery") => 'Доставка',
            config("$this->prefix.cf.application_source") => 'Сайт ЦВЕТОФОР',

        ];

        foreach ($fields as $field => $value) {
            $cf->add((new TextCustomFieldValuesModel())
                ->setFieldId($field)
                ->setValues(
                    (new TextCustomFieldValueCollection())
                        ->add((new TextCustomFieldValueModel())->setValue($value))));
        }


        $paymentMethodId = config("$this->prefix.cf.payment_method_map.{$order->payment->code}");
        $cf->add((new SelectCustomFieldValuesModel())
            ->setFieldId(config("$this->prefix.cf.payment_method"))
            ->setValues((new SelectCustomFieldValueCollection())
                ->add((new SelectCustomFieldValueModel())->setEnumId($paymentMethodId))));

        $cf->add((new DateCustomFieldValuesModel())
            ->setFieldId(config("$this->prefix.cf.delivery_date"))
            ->setValues((new DateCustomFieldValueCollection())
                ->add((new DateCustomFieldValueModel())->setValue($order->delivery_date))),
        );

        $commentText = !empty($order->comment) ? $order->comment . "\n" : '';
        $commentText .= !empty($order->postcard_text) ? "\nОткрытка:\n" . $order->postcard_text : '';

        $cf->add((new TextareaCustomFieldValuesModel())
            ->setFieldId(config("$this->prefix.cf.order_comment"))
            ->setValues((new TextareaCustomFieldValueCollection())
                ->add((new TextareaCustomFieldValueModel())->setValue($commentText))));

        [$orderStructure, $receipt, $packaging] = $this->extractProductsInformation($order);

        $cf->add((new NumericCustomFieldValuesModel())
            ->setFieldId(config("$this->prefix.cf.packaging_cost"))
            ->setValues((new NumericCustomFieldValueCollection())
                ->add((new NumericCustomFieldValueModel())->setValue($packaging))));

        $cf->add((new TextareaCustomFieldValuesModel())->setFieldId(config("$this->prefix.cf.order_structure"))
            ->setValues(
                (new TextareaCustomFieldValueCollection())
                    ->add((new TextareaCustomFieldValueModel())->setValue($orderStructure))));

        $cf->add((new TextareaCustomFieldValuesModel())
            ->setFieldId(config("$this->prefix.cf.receipt"))
            ->setValues((new TextareaCustomFieldValueCollection())
                ->add((new TextareaCustomFieldValueModel())->setValue($receipt))));

        return $cf;
    }

    protected function makeAdminOrderUrl(Order $order): string
    {
        return !empty($order->parent_id)
            ? "https://цветофор.рф/hub/orders/$order->id/edit"
            : '';
    }

    protected function makeDeliveryAddressValue(Order $order): string
    {
        return !empty($order->address)
            ? implode(', ', array_filter(array_merge(
                (array)data_get($order->address, 'address'),
                !empty(data_get($order->address, 'apartament_number')) ? [data_get($order->address, 'apartament_number')] : [],
            )))
            : 'Уточнить у получателя';
    }

    protected function extractProductsInformation(Order $order): array
    {
        $cartItems = $order->cart;
        $orderStructure = "";
        $receipt = "";
        $lastIndex = count($cartItems) - 1;
        $currentIndex = 0;
        $packaging = 0;

        if (!empty($cartItems)) {
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

                        $orderStructure .= "- $bouquetTitle: " . trim(($componentBouquetCount ?: '') . ($componentBouquetCount && $bouquetColor?->title ? ', ' : '') . ($bouquetColor?->title ?: '')) . "\n";
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
}
