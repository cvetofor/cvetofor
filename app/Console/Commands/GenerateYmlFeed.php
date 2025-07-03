<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category; // Модель категорий
use App\Models\GroupProduct;
use App\Models\GroupProductCategory;
use App\Models\Market;
use App\Models\ProductPrice;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class GenerateYmlFeed extends Command {
    protected $signature = 'export-yml:products';
    protected $description = 'Generate YML feed for Yandex Market';
    public $SITE_URL = 'https://цветофор.рф';
    public $SITE_NAME = 'цветофор.рф';

    public function handle() {
        $cities = app(\App\Services\CitiesService::class)->getActiveCities();
        foreach ($cities as $city) {
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><yml_catalog date="' . date('Y-m-d\TH:i:sP') . '"></yml_catalog>');
            $shop = $xml->addChild('shop');

            $shop->addChild('name', "Цветофор ($city->city)");
            $shop->addChild('company', 'ИП Берков М. В.');
            $shop->addChild('url', $this->SITE_URL);

            $currencies = $shop->addChild('currencies');
            $currency = $currencies->addChild('currency');
            $currency->addAttribute('id', 'RUR');
            $currency->addAttribute('rate', '1');

            $categories = $shop->addChild('categories');
            $productCategories = GroupProductCategory::published()->get();
            foreach ($productCategories as $productCategory) {
                $category = $categories->addChild('category', $productCategory->title);
                $category->addAttribute('id', $productCategory->id);
            }

            $offers = $shop->addChild('offers');
            $marketId = Market::where('city_id', $city->id)->first()->id;
            $products = GroupProduct::whereHas('remains', function ($query) use ($marketId) {
                $query->where('market_id', $marketId);
            })->get();
            foreach ($products as $product) {
                $price = $product->priceObj()->where('market_id', $marketId)->first()->price;
                if ($price > 0) {
                    $offer = $offers->addChild('offer');
                    $offer->addAttribute('id', $product->id);
                    $offer->addAttribute('available', 'true');
                    $offer->addChild('url', $this->SITE_URL . $product->priceObj->link);
                    $offer->addChild('price', $price);
                    $offer->addChild('currencyId', 'RUR');
                    $offer->addChild('categoryId', $product->category_id);
                    $offer->addChild('picture', htmlspecialchars($product->image('cover')));
                    $offer->addChild('name', htmlspecialchars($product->title, ENT_XML1 | ENT_QUOTES, 'UTF-8'));
                    $offer->addChild('delivery', true);
                    $offer->addChild('vendor', $this->SITE_NAME);
                    $offer->addChild('sales_notes', 'Онлайн-оплата');

                    // Получаем состав букета через сервис CompositeProducts
                    $compositeProducts = app(\App\Services\CompositeProducts::class);
                    $priceObj = $product->priceObj()->where('market_id', $marketId)->first();
                    $compositionBlocks = $compositeProducts->get($priceObj);
                    $compositionText = '';
                    if ($compositionBlocks) {
                        foreach ($compositionBlocks as $block) {
                            foreach ($block as $item) {
                                $compositionText .= $item->title . ' — ' . $item->count . ' шт.; ';
                            }
                        }
                    }

                    $offer->addChild('description', htmlspecialchars($compositionText, ENT_XML1 | ENT_QUOTES, 'UTF-8'));
                }
            }
            $xmlContent = $xml->asXML();

            $fileName = $this->transliterate($city->city);
            $filePath = "public/export/$fileName.xml";
            Storage::put($filePath, $xmlContent);
            $this->info('Products exported successfully to ' . $filePath);
        }

        return 0;
    }

    private function transliterate($text) {
        $replace = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'yo',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'ts',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ъ' => '',
            'ы' => 'y',
            'ь' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'Yo',
            'Ж' => 'Zh',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'Y',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'H',
            'Ц' => 'Ts',
            'Ч' => 'Ch',
            'Ш' => 'Sh',
            'Щ' => 'Sch',
            'Ъ' => '',
            'Ы' => 'Y',
            'Ь' => '',
            'Э' => 'E',
            'Ю' => 'Yu',
            'Я' => 'Ya',
            ' ' => '_'
        ];
        return strtr($text, $replace);
    }
}
