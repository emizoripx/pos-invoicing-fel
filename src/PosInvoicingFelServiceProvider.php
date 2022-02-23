<?php

namespace EmizorIpx\PosInvoicingFel;

use EmizorIpx\PosInvoicingFel\Providers\PosInvoicingFelEventServiceProvider;
use Illuminate\Support\ServiceProvider;

class PosInvoicingFelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->loadRoutesFrom(__DIR__."/Routes/api.php");

        // Event Service Provider
        $this->app->register(PosInvoicingFelEventServiceProvider::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // ROUTES
        $this->loadRoutesFrom(__DIR__."/Routes/api.php");

        // MIGRATIONS

        $this->loadMigrationsFrom(__DIR__."/Database/Migrations");
    }
}
