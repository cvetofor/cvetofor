<?php

namespace App\Services;

class Helpers
{
    public static function changeKeymap($string, $ruToEn = false)
    {
        $replace = array(
            "й", "ц", "у", "к", "е", "н", "г", "ш", "щ", "з", "х", "ъ",
            "ф", "ы", "в", "а", "п", "р", "о", "л", "д", "ж", "э",
            "я", "ч", "с", "м", "и", "т", "ь", "б", "ю"
        );
        $search = array(
            "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "[", "]",
            "a", "s", "d", "f", "g", "h", "j", "k", "l", ";", "'",
            "z", "x", "c", "v", "b", "n", "m", ",", "."
        );
        if (!$ruToEn) {
            return str_replace($search, $replace, $string);
        }
        return str_replace($replace, $search, $string);
    }

    public static function num2word($num, $words)
    {
        $num = $num % 100;
        if ($num > 19) {
            $num = $num % 10;
        }
        switch ($num) {
            case 1: {
                    return ($words[0]);
                }
            case 2:
            case 3:
            case 4: {
                    return ($words[1]);
                }
            default: {
                    return ($words[2]);
                }
        }
    }



    /**
     * Вычисляет большое расстояние между двумя точками, с
     * Формула Haversine.
     * @param float $ latitude от широты начальной точки в [Deg Decimal]
     * @param float $ долготы от долготы начальной точки в [Deg Decimal]
     * @param float $ широты до широты целевой точки в [deg decimal]
     * @param float $ долготы до долготы целевой точки в [Deg Decimal]
     * @param float $ Радиус Земля означает радиус Земли в [M]
     * @return Float Расстояние между точками в [км] (так же, как радиус Земли)
     */
    public static function haversineGreatCircleDistance(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = 6371
    ) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }



    /**
     * Сумма прописью.
     */
    public static function  strPrice($value)
    {
        $value = explode('.', number_format($value, 2, '.', ''));
        $f = new \NumberFormatter('ru', \NumberFormatter::SPELLOUT);
        $str = $f->format($value[0]);
        // Первую букву в верхний регистр.
        $str = mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1, mb_strlen($str));
        // Склонение слова "рубль".
        $num = $value[0] % 100;
        if ($num > 19) {
            $num = $num % 10;
        }
        switch ($num) {
            case 1:
                $rub = 'рубль';
                break;
            case 2:
            case 3:
            case 4:
                $rub = 'рубля';
                break;
            default:
                $rub = 'рублей';
        }

        return $str . ' ' . $rub . ' ' . $value[1] . ' копеек.';
    }
}
