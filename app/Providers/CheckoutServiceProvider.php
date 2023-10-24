<?php

namespace App\Providers;

use App\Interfaces\CheckoutStrategy;
use App\Strategies\TaxAndServiceCheckout;
use Illuminate\Support\ServiceProvider;

class CheckoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CheckoutStrategy::class,
            TaxAndServiceCheckout::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
