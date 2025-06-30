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
        foreach ($cities as $key => $city) {
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
            $productCategories = app(\App\Services\CatalogService::class)->getPublishedCategoriesFeed($city->id);
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

                    if (isset($product->description)) {
                        $offer->addChild('description', htmlspecialchars($product->description, ENT_XML1 | ENT_QUOTES, 'UTF-8'));
                    }
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




// <yml_catalog date="2024-06-29 12:00">
//   <shop>
//     <name>Название вашего магазина</name>
//     <company>Название компании</company>
//     <url>https://example.com</url>
//     <currencies>
//       <currency id="RUR" rate="1"/>
//     </currencies>
    
// <categories>
//       <category id="1">Электроника</category>
//       <category id="2">Смартфоны</category>
    
// </categories>
    
// <offers>
//       <offer id="123" available="true">
//         <url>https://example.com/product123</url>
//         <price>10000</price>
//         <currencyId>RUR</currencyId>
//         <categoryId>2</categoryId>
//         <picture>https://example.com/image123.jpg</picture>
//         <name>Смартфон Xiaomi Redmi Note 10 Pro</name>
//         <vendor>Xiaomi</vendor>
//         <model>Redmi Note 10 Pro</model>
//         <description>Смартфон Xiaomi Redmi Note 10 Pro с 6.67-дюймовым AMOLED-экраном, процессором Snapdragon 732G и камерой 108 Мп.</description>
//       </offer>
//        <offer id="456" available="false">
//         <url>https://example.com/product456</url>
//         <price>25000</price>
//         <currencyId>RUR</currencyId>
//         <categoryId>1</categoryId>
//         <picture>https://example.com/image456.jpg</picture>
//         <name>Телевизор Samsung UE55AU7100UXCE</name>
//         <vendor>Samsung</vendor>
//         <model>UE55AU7100UXCE</model>
//         <description>55-дюймовый LED-телевизор Samsung UE55AU7100UXCE с разрешением 4K.</description>
//       </offer>
    
// </offers>
//   </shop>
// </yml_catalog>

// <yml_catalog>: Корневой элемент фида.
// <shop>: Блок с информацией о магазине.
// <name>: Название магазина.
// <company>: Название компании.
// <url>: URL магазина.
// <currencies>: Блок с валютами.
// <currency>: Информация о валюте (например, RUR).
