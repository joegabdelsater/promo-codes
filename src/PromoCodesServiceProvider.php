<?php

namespace YllwDigital\PromoCodes;

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
            __DIR__.'/migrations/2023_05_05_084355_create_promo_codes_table.php',
            __DIR__.'/migrations/2023_05_05_102906_create_user_promo_codes_table.php',
        ]);
    }
}
