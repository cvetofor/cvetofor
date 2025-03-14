<?php

namespace App\Services;

class DeliveryService
{
    /**
     * Функция проверяет по координатам, что то точка лежит в радиусе
     *
     * @param float $x1
     * @param float $y1
     * @param float $x2
     * @param float $y2
     * @param integer $radius
     */
    public static function inRadius(float $x1, float $y1, float $x2, float $y2, int $radius)
    {
        #=sqrt(pow(x2-x1, 2) + pow(y2-y1, 2))
    }
}
