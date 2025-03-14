<?php

namespace App\Providers;

use App\Models\Category;
use A17\Twill\Models\Block;
use App\Services\CitiesService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Laravel\Dusk\DuskServiceProvider;
use A17\Twill\Facades\TwillNavigation;
use Illuminate\Support\Facades\Schema;
use A17\Twill\Facades\TwillAppSettings;
use A17\Twill\Models\Tag;
use Illuminate\Support\ServiceProvider;
use A17\Twill\Services\Settings\SettingsGroup;
use A17\Twill\View\Components\Navigation\NavigationLink;
use App\Models\GroupProduct;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        Blade::directive('isPageActive', function ($expression) {
            list($pattern, $class) = explode(',', str_replace(['(', ')', ' ', "'"], '', $expression));
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
        if (!app()->runningInConsole()) {
            $ttl = 60;
            $_menuHeader = Cache::remember('_menuHeader', $ttl, function () {
                return TwillAppSettings::get('public.public.header_menu') ?? [];
            });
            view()->share('_menuHeader', $_menuHeader);

            $_menuFooter = Cache::remember('_menuFooter', $ttl, function () {
                return TwillAppSettings::get('public.public.footer_menu') ?? [];
            });
            view()->share('_menuFooter', $_menuFooter);

            $_menuFooterSecond = Cache::remember('_menuFooterSecond', $ttl, function () {
                return TwillAppSettings::get('public.public.footer_menu_second') ?? [];
            });
            view()->share('_menuFooterSecond', $_menuFooterSecond);

            $_flowers_menu = Cache::remember('_flowers_menu', $ttl, function () {
                return TwillAppSettings::get('public.public.flowers_menu') ?? [];
            });
            view()->share('_flowers_menu', $_flowers_menu);


            view()->composer('*', function ($view) {

                $groupProductTags = \Cache::remember('tags_header|' . \App\Services\CitiesService::getCity()->id ?? '', now()->addMinutes(3), fn() => \A17\Twill\Models\Tag::whereHas('groupProducts', function ($q) {

                    $markets = \App\Models\Market::published()->where('city_id', \App\Services\CitiesService::getCity()->id)->pluck('id');

                    return $q->whereHas('remains', function ($qr) use ($markets) {
                        return $qr->where('published', true)->whereIn('market_id', $markets);
                    });

                })->get());

                $view->with('groupProductTags', $groupProductTags);
            });
        }
    }
}
