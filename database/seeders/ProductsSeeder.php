<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Repositories\ProductRepository;

class ProductsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (Product::count() == 0) {
            /*Розы*/ {
                $category = Category::where('title', 'Розы')->first();
                $productRepository = new ProductRepository(new Product);

                $productRepository->create([
                    'title' => 'Роза Кения/Россия 40 см',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза Кения/Россия 50 см',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза Кения/Россия 60 см',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза Эквадор 40 см',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза Эквадор 50 см',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза Эквадор 60 см',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза Эквадор 70 см',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза кустовая',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза кустовая пионовидная',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза кустовая двухцветная',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза Крашенная',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза Вувузела',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза пионовидная',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Роза Пинк Охара',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Другие цветки*/ {
                $category = Category::where('title', 'Другие цветки')->first();
                $productRepository->create([
                    'title' => 'Альстромерия',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Альстромерия Гарда',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Амариллис',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Амми',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Анемон',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Антирринум (львиный зев)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Артишок',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Астильба',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Астра',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Астранция',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ваксфлауэр',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ваксфлауэр пинк',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Вероника',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Гвоздика',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Гвоздика кустовая',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Георгин (далия)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Гербера',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Гербера мини',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Гиацинт',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Гиперикум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Гиппеаструм',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Гипсофила',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Гладиолус',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Гортензия',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Дельфиниум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ирис',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Калла',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Капс Берзелия',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Капс Бруния',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Клематис',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Краспедия',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Лаванда 1 ветка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Лагурус',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Леукадендрон кустовой',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Лилия "Азиатская" 1 ветка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Лилия ветка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Лимониум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Лотос',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Матиола',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Мимоза (1 ветка)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Мускари',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Нарцисс',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Орнитогалум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Орхидея Ванда 1 бутон',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Орхидея Дендробиум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Орхидея Фаленопсис 1 бутон',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Орхидея Цимбидиум 1 бутон',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Очиток',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Папавер',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Пион',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Пион Сара Бернар',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подсолнух',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ранункулюс',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ромашка Камилла',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ромашка королевская',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ромашка матрикария',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ромашка Танацетум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Седум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Сирень',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Скабиоза',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Скимия',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Солидаго',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Статица',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Суккулент',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Трахелиум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Туя',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Тюльпан',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Тюльпан пионовидный',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Флокс',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Фрезия',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Хамелациум (Шамелациум)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Хелеборус',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Хлопок 1 бутон',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Хлопок пучок',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Хризантема Антонов крупная',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Хризантема кустовая',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Хризантема кустовая Филин Грин',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Хризантема Момоко',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Хризантема одноголовая',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Хризантема Сантини',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Целлозия',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Эрингиум синий',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Эустома (Лизиантус)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => ' Альстромерия',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Зелень*/ {
                $category = Category::where('title', 'Зелень')->first();
                $productRepository->create([
                    'title' => 'Акроклинум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Амарантус зеленый',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Антуриум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Аралия',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Аспарагус',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Аспидистра',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Астильба Эрика',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Берграс',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Бовардия',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Брассика',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Бруния серая',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Буксус',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Буплерум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Верба',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Вибурнум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Диантус',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Илекс (красный)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Калина ягоды (1 ветка)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Капсела',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Леукоспермум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Лист "Чико"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Листья Дуба',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Листья малины (1 ветка)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Нобилис (голубая ель)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Озотамнус',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Осока',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Паникум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Папоротник',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Пастушья сумка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Пистация',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Писташ',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Питтоспорум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Плюмозус',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Протея',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Пшеница (тритикум) 1 колосок',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Рускус',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Рускус Итальянский',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Салал',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Салал мини',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Тласпи "Грин Белл"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Фисташка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Фитоспорум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Флеум',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Эвкалипт',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Ленты*/ {
                $category = Category::where('title', 'Ленты')->first();
                $productRepository->create([
                    'title' => 'Бечевка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Кружево',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Лента атласная',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }

            /*Упаковка*/ {
                $category = Category::where('title', 'Упаковка')->first();
                $productRepository->create([
                    'title' => 'Белая матовая пленка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Бирюзовая матовая пленка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Бумага-жатка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Бумага матовая',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Джут',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Зеленая матовая пленка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Калька',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Каркас плетеный ручной работы',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Красная матовая пленка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Крафт-газета',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Крафт-конус',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Крафт однотонный',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Малиновая матовая пленка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Мешковина',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Оранжевая матовая пленка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Органза',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Плёнка матовая',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Прозрачная пленка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Розовая матовая пленка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Сетка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Синяя матовая пленка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Тишью',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Фетр',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Целлофан',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Черная матовая пленка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Коробки*/ {
                $category = Category::where('title', 'Коробки')->first();
                $productRepository->create([
                    'title' => 'Коробка малый прямоугольник',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Коробка средний прямоугольник',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Коробка большой прямоугольник',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Коробка малый круг',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Коробка средний круг',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Коробка большой круг',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Коробка малый сердце',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Коробка средний сердце',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Коробка большой сердце',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Коробка Трапеция средний прочее',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ящик без ручки малый прямоугольник',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ящик без ручки средний прямоугольник',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ящик без ручки большой прямоугольник',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ящик с ручкой малый прямоугольник',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ящик с ручкой средний прямоугольник',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ящик с ручкой большой прямоугольник',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Шляпные коробки*/ {
                $category = Category::where('title', 'Шляпные коробки')->first();
                $productRepository->create([
                    'title' => 'Шляпная коробка малый',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Шляпная коробка средний',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Шляпная коробка большой',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Корзины*/ {
                $category = Category::where('title', 'Корзины')->first();
                $productRepository->create([
                    'title' => 'Корзина малый',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина средний',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина большой',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина малый овал',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина средний овал',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина большой овал',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина для 1000 роз большой',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина для 300 роз большой',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина для 500 роз',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Прочее*/ {
                $category = Category::where('title', 'Прочее')->first();
                $productRepository->create([
                    'title' => 'Аквабокс',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Аквапак',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Амарант',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ананас',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ангел (статуэтка)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Анис',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Апельсин',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Банан',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Божья коровка декор',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Буквы из шоколада',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Булавки',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Бусины',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Вафельный рожок',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ветка Пихты или Ели',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ветки декоративные',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Виноград 1шт.',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Декоративный снег',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Карандаш',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Каркас',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Кашпо декоративное',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Кашпо конверт',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Кашпо шестигранник',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Киви',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Колбы для роз',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корица',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Латирус (душистый горошек)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Линейка декор',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Мандарин декоративный',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Мыло ручной работы',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Нигелла',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Новогодний декор',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Перья декоративные',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Пиафлор / оазис/ флор. губка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Поддон',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подснежник',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Рафия',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ротанг',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Свеча большая',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Сухоцвет "Колосок", 1 стебель',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Удлинитель',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Фигурка "Ангел"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Фоамиран',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Шар декоративный',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Шишки сосновые',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Шпажка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Яблоко декоративное',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Макаруны*/ {
                $category = Category::where('title', 'Макаруны')->first();
                $productRepository->create([
                    'title' => 'Макаронс 1 шт.',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Макаронс 8 шт. в коробке',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Сладкое*/ {
                $category = Category::where('title', 'Сладкое')->first();
                $productRepository->create([
                    'title' => 'Ferrero 1 шт',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Raffaello коробка',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Raffaello (Рафаэлло) 1 конфета',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Зефир 1шт',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Киндер шоколад (1шт)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Конфеты Коркунов 192 гр.',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Кремовый торт 400-500 гр.',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Кремовый торт 900-1000 гр.',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Яйцо киндер',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Вазы*/ {
                $category = Category::where('title', 'Вазы')->first();
            }
            /*Букеты с фруктами*/ {
                $category = Category::where('title', 'Букеты с фруктами')->first();
                $productRepository->create([
                    'title' => 'Клубника (1 ягода)',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Шары*/ {
                $category = Category::where('title', 'Шары')->first();
                $productRepository->create([
                    'title' => 'Шар с гелием',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Живые бабочки*/ {
                $category = Category::where('title', 'Живые бабочки')->first();
            }
            /*Мягкие игрушки*/ {
                $category = Category::where('title', 'Мягкие игрушки')->first();
                $productRepository->create([
                    'title' => 'Мишка бол',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Мишка мал',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Мишка сред',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Подарки*/ {
                $category = Category::where('title', 'Подарки')->first();
            }
            /*Топперы*/ {
                $category = Category::where('title', 'Топперы')->first();
                $productRepository->create([
                    'title' => 'Топпер "1-е Сентября"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "1 Сентября"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "1 сентября"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "Дорогому учителю"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "Любимой бабушке"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "Любимой жене"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "Любимой маме"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "Любимой мамочке"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "Люблю"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "Мамочке"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "Мамуле"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "Моей первой учительнице"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "Обещаю хорошо учиться"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "От всей души"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "Поздравляем!"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "Поздравляю"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Топпер "С Днём Рождения"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Ты в моем сердце',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Фруктовые корзины*/ {
                $category = Category::where('title', 'Фруктовые корзины')->first();
                $productRepository->create([
                    'title' => 'Бодрое утро',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Будь здоров',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Добрый ананас',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина с фруктами №1',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина с фруктами №2',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина с фруктами "Фруктовая',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина Фруктов 4 кг',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина фруктов 6 кг',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Натюрморт 	Ананас - 2 шт',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина "Фрукты с шоколадом"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Свежесть',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Фруктовая корзина',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Фруктовая корзина 5 кг',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Фруктовая корзина №1',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Фруктовая корзина №2',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Фруктовый букет',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Фруктовый рай',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Подарочные корзины*/ {
                $category = Category::where('title', 'Подарочные корзины')->first();
                $productRepository->create([
                    'title' => 'Букет для сладкоежки XL',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Детский подарочный набор №1',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Детский подарочный набор №2 "Киндер сюрприз"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Женская подарочная корзина №3',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина киндер-сюрпризов',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Корзина сладостей',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Новогодний набор с конфетами и чаем',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №1',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №10 "Красная"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №1 "Кофе и чай"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №2',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №2 "К чаю"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №3',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №3 "Любителю кофе"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №4 "Похрустеть с колой"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №5 "Детская"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №6 "Закусить"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №7 "Соки воды"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №8 "Продуктовая"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина №9 "All inclusive"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина новогодних вкусностей',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочная корзина "Сладкий ананас"',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Подарочный набор №2',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Продуктовая корзина',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Сладкий гостинец',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Сладкий сюрприз',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
                $productRepository->create([
                    'title' => 'Чайная корзина',
                    'category_id' => $category->id,
                    'published' => true,
                    'is_market_public' => true,
                    'verified_at' => now(),
                ]);
            }
            /*Флорариумы*/ {
                $category = Category::where('title', 'Флорариумы')->first();
            }
            /*Съедобные букеты*/ {
                $category = Category::where('title', 'Съедобные букеты')->first();
            }
        }
    }
}
