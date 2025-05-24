<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (Color::count() == 0) {

            $colorRepository = new Color;

            $colorRepository->create([
                'title' => 'Красные',
                'data' => [
                    'rgb' => '#FF0000',
                ],
                'published' => true,
            ]);
            $colorRepository->create([
                'title' => 'Белые',
                'data' => [
                    'rgb' => '#f2f3f4',
                ],
                'published' => true,
            ]);
            $colorRepository->create([
                'title' => 'Кремовые',
                'data' => [
                    'rgb' => '#f2ddc6',
                ],
                'published' => true,
            ]);
            $colorRepository->create([
                'title' => 'Нежно-розовые',
                'data' => [
                    'rgb' => '#ffa9c3',
                ],
                'published' => true,
            ]);
            $colorRepository->create([
                'title' => 'Желтые',
                'data' => [
                    'rgb' => '#FFFF00',
                ],
                'published' => true,
            ]);
            $colorRepository->create([
                'title' => 'Оранжевые',
                'data' => [
                    'rgb' => '#FFA500',
                ],
                'published' => true,
            ]);
            $colorRepository->create([
                'title' => 'Персиковые',
                'data' => [
                    'rgb' => '#FFDAB9',
                ],
                'published' => true,
            ]);
            $colorRepository->create([
                'title' => 'Ярко-розовые',
                'data' => [
                    'rgb' => '#dc2d63',
                ],
                'published' => true,
            ]);
            $colorRepository->create([
                'title' => 'Фиолетовые',
                'data' => [
                    'rgb' => '#8b00ff',
                ],
                'published' => true,
            ]);
            $colorRepository->create([
                'title' => 'Зеленые',
                'data' => [
                    'rgb' => '#228B22',
                ],
                'published' => true,
            ]);
            $colorRepository->create([
                'title' => 'Коралловые',
                'data' => [
                    'rgb' => '#FF7F50',
                ],
                'published' => true,
            ]);
            $colorRepository->create([
                'title' => 'Ярко-сиреневые',
                'data' => [
                    'rgb' => '#ff00ff',
                ],
                'published' => true,
            ]);
            $colorRepository->create([
                'title' => 'Нежно-сиреневые',
                'data' => [
                    'rgb' => '#c8a2c8',
                ],
                'published' => true,
            ]);
        }
    }
}
