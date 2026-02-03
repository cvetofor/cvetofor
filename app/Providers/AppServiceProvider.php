<?php

namespace App\Providers;

use A17\Twill\Facades\TwillAppSettings;
use A17\Twill\Models\Tag;
use App\Models\GroupProduct;
use App\Models\MenuFlover;
use App\Models\MenuPrice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {


        Blade::directive('isPageActive', function ($expression) {
            [$pattern, $class] = explode(',', str_replace(['(', ')', ' ', "'"], '', $expression));

            return "<?= request()->is('$pattern') ? '$class' : ''; ?>";
        });

        Tag::resolveRelationUsing('groupProducts', function ($model) {
            return $model->morphedByMany(GroupProduct::class, 'taggable', 'tagged');
        });

        Blade::directive('to_phone', function ($expression) {
            return "<?= str_replace(['(', ')', '-', ' '], ['', '', '', ''], $expression); ?>";
        });

        Blade::directive('money', function ($money) {
            return "<?php echo str_replace('.00','',number_format($money, 2 , '.' , ' ')); ?>";
        });

        Blade::directive('moneyRu', function ($money) {
            return "<?php echo ' '.number_format($money, 0); ?>";
        });


        if (! app()->runningInConsole()) {
            \View::share('menuPrices', MenuPrice::orderBy('sort')->get());
            \View::share('menuFlovers', MenuFlover::orderBy('sort')->get());
            $ttl = 60;
            /* $_menuHeader = Cache::remember('_menuHeader', $ttl, function () {
                 return TwillAppSettings::get('public.public.header_menu') ?? [];
             });*/
            $_menuHeader = TwillAppSettings::get('public.public.header_menu') ?? [];
            view()->share('_menuHeader', $_menuHeader);

            /* $_menuFooter = Cache::remember('_menuFooter', $ttl, function () {
                 return TwillAppSettings::get('public.public.footer_menu') ?? [];
             });*/
            $_menuFooter = TwillAppSettings::get('public.public.footer_menu') ?? [];
            view()->share('_menuFooter', $_menuFooter);

            /* $_menuFooterSecond = Cache::remember('_menuFooterSecond', $ttl, function () {
                 return TwillAppSettings::get('public.public.footer_menu_second') ?? [];
             });*/
            $_menuFooterSecond= TwillAppSettings::get('public.public.footer_menu_second') ?? [];
            view()->share('_menuFooterSecond', $_menuFooterSecond);

            /* $_flowers_menu = Cache::remember('_flowers_menu', $ttl, function () {
                 return TwillAppSettings::get('public.public.flowers_menu') ?? [];
             });*/
            $_flowers_menu=TwillAppSettings::get('public.public.flowers_menu') ?? [];
            view()->share('_flowers_menu', $_flowers_menu);

            view()->composer('*', function ($view) {

                $groupProductTags =\A17\Twill\Models\Tag::whereHas('groupProducts', function ($q) {

                    $markets = \App\Models\Market::published()->where('city_id', \App\Services\CitiesService::getCity()->id)->pluck('id');

                    return $q->whereHas('remains', function ($qr) use ($markets) {
                        return $qr->where('published', true)->whereIn('market_id', $markets);
                    });
                })->get();
                /*$groupProductTags = \Cache::remember('tags_header|' . \App\Services\CitiesService::getCity()->id ?? '', now()->addMinutes(3), fn() => \A17\Twill\Models\Tag::whereHas('groupProducts', function ($q) {

                    $markets = \App\Models\Market::published()->where('city_id', \App\Services\CitiesService::getCity()->id)->pluck('id');

                    return $q->whereHas('remains', function ($qr) use ($markets) {
                        return $qr->where('published', true)->whereIn('market_id', $markets);
                    });
                })->get());*/

                $view->with('groupProductTags', $groupProductTags);
            });
        }
    }
}
