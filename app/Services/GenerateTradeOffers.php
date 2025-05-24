<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class GenerateTradeOffers
{
    /**
     * Генерация Торговых предложений
     *
     * @return void
     */
    public static function generate(int|array $id)
    {
        DB::transaction(function () use ($id) {
            if (is_array($id)) {
                foreach ($id as $i) {
                    self::__generate($i);
                }
            } else {
                self::__generate($id);
            }
        }, 3);
    }

    private static function __generate(int $id) {}
}
