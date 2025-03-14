<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Color;
use App\Models\Category;
use A17\Twill\Models\Tag;
use Illuminate\Support\Str;
use App\Models\GroupProduct;
use Illuminate\Database\Seeder;
use Cartalyst\Tags\IlluminateTag;
use Illuminate\Support\Facades\DB;
use App\Repositories\ColorRepository;

class TagsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (IlluminateTag::count() == 0) {

            $tag = new IlluminateTag;

            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('8 марта'),
                'name' => '8 марта',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Цветы для любимой'),
                'name' => 'Цветы для любимой',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Свадебные букеты'),
                'name' => 'Свадебные букеты',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Бизнес-букеты'),
                'name' => 'Бизнес-букеты',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Декор для дома и офиса'),
                'name' => 'Декор для дома и офиса',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('День рождения'),
                'name' => 'День рождения',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Цветы для женщины'),
                'name' => 'Цветы для женщины',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Цветы для мужчины'),
                'name' => 'Цветы для мужчины',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Цветы для мамы'),
                'name' => 'Цветы для мамы',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Цветы для жены'),
                'name' => 'Цветы для жены',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Цветы для подруги'),
                'name' => 'Цветы для подруги',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Эквадор'),
                'name' => 'Эквадор',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Собрано сегодня'),
                'name' => 'Собрано сегодня',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Самые яркие и сочные букеты'),
                'name' => 'Самые яркие и сочные букеты',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Яркие букетики'),
                'name' => 'Яркие букетики',
                'count' => 0,
            ]);
            $tag->create([
                'namespace' => GroupProduct::class,
                'slug' => Str::slug('Коробки-сердца'),
                'name' => 'Коробки-сердца',
                'count' => 0,
            ]);
        }
    }
}
