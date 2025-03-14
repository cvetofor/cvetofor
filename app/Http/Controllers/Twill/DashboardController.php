<?php

namespace App\Http\Controllers\Twill;

use App\Http\Resources\DashboardSearchResource;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


class DashboardController extends \A17\Twill\Http\Controllers\Admin\DashboardController
{
    public function search(Request $request): Collection
    {
        $data = parent::search($request);


        return DashboardSearchResource::collection($data)->transform(function ($value) {


            if ($value['type'] == 'ProductPrice') {
                $val = ProductPrice::where('id', $value['id'])->first();

                if (!\Gate::allows('edit', $val))
                    return false;


                $item = $val->groupProduct;
                return [
                    'id'        => $item->id,
                    'href'      => moduleRoute('groupProducts', null, 'edit', $item->id),
                    'thumbnail' => method_exists($item, 'defaultCmsImage') ? $item->defaultCmsImage(['w' => 100, 'h' => 100]) : null,
                    'published' => $item->published,
                    'activity'  => twillTrans('twill::lang.dashboard.search.last-edit'),
                    'date'      => '',
                    'title'     => $item->titleInDashboard ?? $item->title,
                    'author'    => '',
                    'type'      => ucfirst('Букеты' ?? Str::singular('groupProducts')),
                ];
            }
            return $value;
        })->filter(
                function ($e) {
                    if (
                        ($e['type'] == 'GroupProduct') || \Gate::allows('is_owner')
                    ) {
                        return $e;
                    }
                    return false;
                }
            );
    }
}
