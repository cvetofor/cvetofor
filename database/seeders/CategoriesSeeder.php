<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\GroupProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Repositories\CategoryRepository;
use App\Repositories\GroupProductCategoryRepository;

class CategoriesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (Category::count() == 0) {

            $categoryRepository = new CategoryRepository(new Category);

            $flower = $categoryRepository->create([
                'title'     => 'Цветы',
                'published' => true,
            ]);


            $categoryRepository->create([
                'title'     => 'Розы',
                'published' => true,
                'parent_id'     => $flower->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Другие цветки',
                'published' => true,
                'parent_id'     => $flower->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Зелень',
                'published' => true,
            ]);

            $materials = $categoryRepository->create([
                'title'     => 'Материалы',
                'published' => true,
            ]);

            $categoryRepository->create([
                'title'     => 'Ленты',
                'published' => true,
                'parent_id'     => $materials->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Упаковка',
                'published' => true,
                'parent_id'     => $materials->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Коробки',
                'published' => true,
                'parent_id'     => $materials->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Шляпные коробки',
                'published' => true,
                'parent_id'     => $materials->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Корзины',
                'published' => true,
                'parent_id'     => $materials->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Прочее',
                'published' => true,
                'parent_id'     => $materials->id,
            ]);

            $addGoods = $categoryRepository->create([
                'title'     => 'Доп. товары',
                'published' => true,
            ]);

            $categoryRepository->create([
                'title'     => 'Макаруны',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Сладкое',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Вазы',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Букеты с фруктами',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Шары',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Живые бабочки',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Мягкие игрушки',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Подарки',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Топперы',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Фруктовые корзины',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Подарочные корзины',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Флорариумы',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);

            $categoryRepository->create([
                'title'     => 'Съедобные букеты',
                'published' => true,
                'parent_id'     => $addGoods->id,
            ]);
        }
        if (GroupProductCategory::count() == 0) {

            $categoryRepository = new GroupProductCategoryRepository(new GroupProductCategory());

            $categoryRepository->create([
                'title'     => 'Букеты',
                'published' => true,
            ]);
            $categoryRepository->create([
                'title'     => 'Цветы в коробке',
                'published' => true,
            ]);
            $categoryRepository->create([
                'title'     => 'Корзины с цветами',
                'published' => true,
            ]);
            $categoryRepository->create([
                'title'     => 'Букеты с фруктами',
                'published' => true,
            ]);
            $categoryRepository->create([
                'title'     => 'Шляпные коробки',
                'published' => true,
            ]);
            $categoryRepository->create([
                'title'     => 'Подарочные корзины',
                'published' => true,
            ]);
            $categoryRepository->create([
                'title'     => 'Фруктовые корзины',
                'published' => true,
            ]);
            $categoryRepository->create([
                'title'     => 'Топперы',
                'published' => true,
            ]);
            $categoryRepository->create([
                'title'     => 'Готовые букеты',
                'published' => true,
            ]);
            $categoryRepository->create([
                'title'     => 'Флорариумы',
                'published' => true,
            ]);
            $categoryRepository->create([
                'title'     => 'Съедобные букеты',
                'published' => true,
            ]);
        }
    }
}
