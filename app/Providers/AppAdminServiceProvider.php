<?php

namespace App\Providers;

use A17\Twill\Facades\TwillAppSettings;
use A17\Twill\Facades\TwillNavigation;
use A17\Twill\Services\Settings\SettingsGroup;
use A17\Twill\View\Components\Navigation\NavigationLink;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppAdminServiceProvider extends ServiceProvider
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
        TwillAppSettings::registerSettingsGroups(
            SettingsGroup::make()->name('seo')->label(trans('twill-metadata::form.titles.fieldset'))->availableWhen(fn () => \Auth::user()->can('edit-settings')),
        );

        TwillAppSettings::registerSettingsGroups(
            SettingsGroup::make()
                ->name('main-page')
                ->label('Главная страница')
                ->availableWhen(fn () => \Auth::user()->can('edit-settings')),
            // Example access control.
            SettingsGroup::make()
                ->name('help-page')
                ->label('Страница помощи')
                ->availableWhen(fn () => \Auth::user()->can('edit-settings')),
            SettingsGroup::make()
                ->name('public')
                ->label('Публичная часть')
                ->availableWhen(fn () => \Auth::user()->can('edit-settings')),
            SettingsGroup::make()
                ->name('legal')
                ->label('Данные юр.лица')
                ->availableWhen(fn () => \Auth::user()->can('edit-settings')),
            SettingsGroup::make()
                ->name('resource')
                ->label('Ресурс')
                ->availableWhen(fn () => \Gate::allows('is_owner')),
        );

        if (Schema::hasTable('categories')) {
            $categories1lvl = Category::published()->orderBy('id')->where('parent_id', null)->get();
            $categories2lvl = Category::published()->whereIn('parent_id', $categories1lvl->pluck('id'))->get();

            $links1 = collect();
            $links1->add(
                NavigationLink::make()
                    ->onlyWhen(fn () => \Auth::user()->can('view-module', 'groupProducts'))
                    ->forModule('groupProducts')
                    ->title('Букеты')
            );
            $links1->push(...$categories1lvl->map(function ($category1) use ($categories2lvl) {

                $items = $categories2lvl->filter(function ($e) use ($category1) {
                    return $category1->id == $e->parent_id;
                });

                $childrens = $items->map(function ($category2) {
                    return NavigationLink::make()->forRoute('twill.products.list', ['category' => "$category2->id"])->title($category2->title);
                });

                return NavigationLink::make()->doNotAddSelfAsFirstChild()->forRoute('twill.products.list', ['category' => "$category1->id"])->title($category1->title)->setChildren(
                    $childrens->toArray()
                );
            }));

            TwillNavigation::addLink(
                NavigationLink::make()
                    ->onlyWhen(fn () => \Auth::user()->can('view-module', 'products'))
                    ->forModule('products')
                    ->doNotAddSelfAsFirstChild()
                    ->title('Каталог')
                    ->setChildren($links1->toArray())
            );
        }

        TwillNavigation::addLink(
            NavigationLink::make()
                ->forModule('markets')
                ->doNotAddSelfAsFirstChild()
                ->title('Магазин')
                ->setChildren(
                    [

                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'orders'))
                            ->forModule('orders')
                            ->title('Заказы'),
                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'deliveries'))
                            ->forModule('deliveries')
                            ->title('Доставки'),

                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'markets'))
                            ->forModule('markets')
                            ->title('Магазины')
                            ->setChildren(
                                [
                                    // NavigationLink::make()->forModule('paymentDetails')->title('Платежные реквизиты'),
                                    // NavigationLink::make()
                                    //     ->onlyWhen(fn() => \Auth::user()->can('view-module', 'marketWorkTimes'))
                                    //     ->forModule('marketWorkTimes')->title('Время работы & доставки'),
                                    // NavigationLink::make()->forModule('stocks')->title('Скидки'),
                                    NavigationLink::make()
                                        ->onlyWhen(fn () => \Auth::user()->can('view-module', 'balances'))
                                        ->forModule('balances')->title('Вывод средств'),
                                    // NavigationLink::make()->forModule('remains')->title('Остатки'),
                                    // NavigationLink::make()->forModule('attributes')->title('Характеристики')->doNotAddSelfAsFirstChild()->setChildren([
                                    //     NavigationLink::make()->forModule('attributes')->title('Характеристики'),
                                    // ]),
                                    // NavigationLink::make()->forModule('productPrices')->title('Цены'),
                                ]
                            ),
                    ]
                )
        );

        TwillNavigation::addLink(
            NavigationLink::make()
                ->onlyWhen(fn () => \Auth::user()->can('view-module', 'pages'))
                ->doNotAddSelfAsFirstChild()
                ->forModule('pages')
                ->title('Сайт')
                ->setChildren(
                    [
                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'pages'))
                            ->forModule('pages')->doNotAddSelfAsFirstChild()->title('Страницы'),

                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'payments'))
                            ->forModule('payments')->title('Платежные системы'),

                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'hollydays'))
                            ->forModule('hollydays')->title('Праздники'),

                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'tags'))
                            ->forModule('tags')->title('Поводы'),

                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'paymentStatuses'))
                            ->forModule('paymentStatuses')->doNotAddSelfAsFirstChild()->title('Статусы')->setChildren(
                                [
                                    NavigationLink::make()
                                        ->onlyWhen(fn () => \Auth::user()->can('view-module', 'orderStatuses'))
                                        ->forModule('orderStatuses')->title('Статусы заказа'),
                                    NavigationLink::make()
                                        ->onlyWhen(fn () => \Auth::user()->can('view-module', 'paymentStatuses'))
                                        ->forModule('paymentStatuses')->title('Статусы платежа'),
                                    NavigationLink::make()
                                        ->onlyWhen(fn () => \Auth::user()->can('view-module', 'deliveryStatuses'))
                                        ->forModule('deliveryStatuses')->title('Статусы доставки'),
                                ]
                            ),
                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'categories'))
                            ->forModule('categories')->title('Категории товаров'),
                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'groupProductCategories'))
                            ->forModule('groupProductCategories')->title('Категории букетов'),
                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'colors'))
                            ->forModule('colors')->title('Палитра цветов'),

                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'regions'))
                            ->forRoute('twill.regions.index')->doNotAddSelfAsFirstChild()->title('Регионы')->setChildren(
                                [
                                    NavigationLink::make()
                                        ->onlyWhen(fn () => \Auth::user()->can('view-module', 'regions'))
                                        ->forModule('regions')->title('Регионы'),
                                    NavigationLink::make()
                                        ->onlyWhen(fn () => \Auth::user()->can('view-module', 'cities'))
                                        ->forModule('cities')->title('Города'),
                                    NavigationLink::make()
                                        ->onlyWhen(fn () => \Auth::user()->can('view-module', 'cities'))
                                        ->forRoute('twill.areas.import')->title('Импорт'),
                                ]
                            ),

                        NavigationLink::make()
                            ->onlyWhen(fn () => \Auth::user()->can('view-module', 'profiles'))
                            ->forRoute('twill.profiles.index')->doNotAddSelfAsFirstChild()->title('Дополнительная информация')->setChildren(
                                [
                                    NavigationLink::make()
                                        ->onlyWhen(fn () => \Auth::user()->can('view-module', 'profiles'))
                                        ->forModule('profiles')->title('Покупатели'),
                                    NavigationLink::make()
                                        ->onlyWhen(fn () => \Auth::user()->can('view-module', 'legalAccounts'))
                                        ->forModule('legalAccounts')->title('Юр.лица'),
                                    NavigationLink::make()
                                        ->onlyWhen(fn () => \Auth::user()->can('view-module', 'reviews'))
                                        ->forModule('reviews')->title('Отзывы'),
                                    NavigationLink::make()
                                        ->onlyWhen(fn () => \Auth::user()->can('view-module', 'forms'))
                                        ->forModule('forms')->title('Форма обратной связи'),
                                ]
                            ),

                    ]
                ),
        );

        TwillNavigation::addLink(
            NavigationLink::make()->forRoute('twill.help')->doNotAddSelfAsFirstChild()->title('Помощь')
        );
    }
}
