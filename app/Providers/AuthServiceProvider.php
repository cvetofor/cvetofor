<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Delivery;
use App\Models\Market;
use App\Models\MarketWorkTime;
use App\Policies\ProductPolicy;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();




        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Подтвердите Email адрес')
                ->greeting("Добро пожаловать!")
                ->line('До завершения регистрации остался всего один шаг. Так мы точно будем знать, что это ваш верный адрес электронной почты. Сюда будут приходить важные новости и информация о ваших покупках. Для подтверждения перейдите по ссылке.')
                ->line('Если вы не регистрировались на нашем сайте, просто проигнорируйте это письмо. ')
                ->action('Подтвердить', $url)
                ->salutation('Хорошего вам дня!');
        });

        \Gate::define('is_owner', function ($user) {
            return $user->is_superadmin || ($user->role->code ?? false) == 'owner';
        });

        \Gate::define('edit', function ($user, $item) {
            return in_array($item->market_id, $user->getMarketIds(), true)
                || \Gate::allows('is_owner')
                || (is_a($item, Market::class) && in_array($item->id, $user->getMarketIds(), true))
                || (is_a($item, Delivery::class) && in_array($item->order->market_id, $user->getMarketIds(), true))
                || (is_a($item, MarketWorkTime::class) && in_array($item->market->id ?? $item->delivery->id, $user->getMarketIds(), true));
        });

        //
    }
}
