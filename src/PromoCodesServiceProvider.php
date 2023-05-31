<?php

namespace Joegabdelsater\PromoCodes;

use Illuminate\Support\ServiceProvider;

class PromoCodesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('promo-codes', function () {
            return new PromoCodeRunner();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom([
            __DIR__.'/Migrations/2023_05_05_084355_create_promo_codes_table.php',
            __DIR__.'/Migrations/2023_05_05_102906_create_user_promo_codes_table.php',
        ]);

        $this->publishes([
            __DIR__.'/Models/PromoCode.php' => app_path('Models'),
            __DIR__.'/Models/UserPromoCode.php' => app_path('Models'),
        ], 'promo-codes-models');
    }
}
