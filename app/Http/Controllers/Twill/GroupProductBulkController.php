<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\Controller;
use App\Models\GroupProduct;
use App\Models\GroupProductCategory;
use App\Models\Market;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class GroupProductBulkController extends Controller
{
    public function index(Request $request)
    {


        $products_sql = GroupProduct::orderby('created_at', 'desc');
        if (is_numeric(request()->market_id)) {
            $products_sql->where('created_by_market_id', $request->market_id);
        }
        if ($request->published == 1) {
            $products_sql->inStock();
        }
        if ($request->published == 0) {
            $products_sql->draft();
        }

        if (request('trash') == 2) {
            $products_sql->onlyTrashed();
        }
        if (request('name') != '') {
            $products_sql->where('title', 'LIKE', '%' . request('name') . '%');
        }
        if (is_numeric(request('category_id')) && request('category_id') > 0) {
            $products_sql->where('category_id', request('category_id'));
        }
        if (is_numeric(request('tag_id')) && request('tag_id') > 0) {
            $products_sql->whereHas('tags', function ($query) {
                $query->where('tag_id', request('tag_id'));
            });
        }
        if (is_numeric(request('price_from'))) {
            $products_sql->whereHas('priceObj', function ($query) {
                $query->where('price', '>=', request('price_from'));
            });
        }
        if (is_numeric(request('price_to'))) {
            $products_sql->whereHas('priceObj', function ($query) {
                $query->where('price', '<=', request('price_to'));
            });
        }
        if (request('flover')) {
            $products = Product::where('title', 'LIKE', '%' . request()->get('flover') . '%')->pluck('id');
            if (count($products) > 0) {
                $products_sql->whereHas('blocks', function ($q) use ($products) {
                    return $q->where('type', 'products')->whereIn('content->browsers->products->0', $products);
                });
            }
            /* $products_sql->whereHas('prices',function ($query) {

                 $query->whereHas('product',function ($query) {

                     $query->where('title', 'LIKE','%'.request()->get('flover').'%');

                 });


             });*/

        }


        $products = $products_sql->paginate(50);


        $markets = Market::published()->get();
        $cats = GroupProductCategory::published()->get();
        $tags = Tag::published()->get();


        return view('twill.bulkgrouproduct.index', compact('cats', 'tags', 'markets', 'products'));
    }

    public function doit()
    {
        $data = request()->all();
        $gets = GroupProduct::whereIN('id', $data['id'])->get();
        switch ($data['doit']) {
            case 'delete':

                foreach ($gets as $get) {
                    $get->delete();
                }

                break;
            case 'publish':
                foreach ($gets as $get) {
                    $get->published = true;
                    $get->save();
                }

                break;
            case 'unpublish':
                foreach ($gets as $get) {
                    $get->published = false;
                    $get->save();
                }
                break;
            case 'site':
                foreach ($gets as $get) {
                    $get->is_public = 1;
                    $get->save();
                }
                break;
            case 'unsite':
                foreach ($gets as $get) {
                    $get->is_public = 0;
                    $get->save();
                }
                break;
            case 'setcat':
                foreach ($gets as $get) {
                    $get->category_id = request('category_id');
                    $get->save();
                }
                break;
            case 'addtag':
                foreach ($gets as $get) {

                    $check = \DB::table('tagged')->where('taggable_id', $get->id)->where('taggable_type', 'App\Models\GroupProduct')
                        ->where('tag_id', request()->tag_id)->first();
                    if (!$check) {
                        \DB::table('tagged')->insert([
                            'taggable_id' => $get->id,
                            'tag_id' => request()->tag_id,
                            'taggable_type' => 'App\Models\GroupProduct',
                        ]);
                    }

                }
                break;
            case 'deletetag':


                \DB::table('tagged')->whereIN('taggable_id', $gets->pluck('id'))->where('taggable_type', 'App\Models\GroupProduct')
                    ->where('tag_id', request()->tag_id)->delete();


                break;
            case 'setprice':
                foreach ($gets as $get) {
                    $get->price=request('price');
                    $get->save();
                }
                break;


            case 'calcprice':

                foreach ($gets as $get) {
                    $summ=0;

                    foreach ($get->blocks->where('type','products') as $price) {

                        $count=$price->content['count']??0;
                        if(!$count){
                            continue;
                        }
                        $prod_id=$price->content['browsers']['products'][0]??0;
                        if(!$prod_id){
                            continue;
                        }

                        $summ+=(ProductPrice::where('product_id', $prod_id)
                            ->where('published', true)

                            ->whereNotNull('price')
                            ->where('quantity_from', '<=', $count)
                            ->orderByDesc('quantity_from')
                            ->first()->price??0)*$count;



                    }
                    $get->price=$summ;
                    $get->save();



//>where('type', 'products')->whereIn('content->browsers->products->0', $products);

                }





            // <option value="addtag">Добавить повод</option>
            //                        <option value="deletetag">Удалить повод</option>


        }


        return back();

    }
}
