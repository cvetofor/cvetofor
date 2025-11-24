<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Promocod;
use App\Models\PromocodList;

class PromocodRepository extends ModuleRepository
{
    use HandleBlocks;

    public function __construct(Promocod $model)
    {
        $this->model = $model;
    }
    public function afterSave($object, $fields): void
    {
        parent::afterSave($object, $fields);

        // Получаем значения
        $code = trim($fields['code'] ?? '');
        $promoall = trim($fields['promoall'] ?? '');

        // Разбиваем promoall на массив
        $promoList = [];

        if (!empty($promoall)) {
            $promoList = array_filter(array_map('trim', explode(',', $promoall)));
        }

        // Добавляем основной code в список
        if (!empty($code)) {
            $promoList[] = $code;
        }

        PromocodList::where('promocod_id', $object->id)->delete();

        // Записываем каждое значение отдельно
        foreach ($promoList as $item) {
            PromocodList::create([
                'promocod_id' => $object->id,
                'code'        => $item,
            ]);
        }
    }
    public function afterDelete($object):void
    {
        parent::afterDelete($object);


        PromocodList::where('promocod_id', $object->id)->delete();
    }

}
