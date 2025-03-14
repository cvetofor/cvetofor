<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TagsSeeder;
use Database\Seeders\ColorsSeeder;
use Database\Seeders\PaymentsSeeder;
use Database\Seeders\ProductsSeeder;
use Database\Seeders\StatusesSeeder;
use Database\Seeders\CategoriesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ColorsSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(PaymentsSeeder::class);
        $this->call(StatusesSeeder::class);
        $this->call(TagsSeeder::class);
    }
}
