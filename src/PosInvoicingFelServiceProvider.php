<?php

namespace EmizorIpx\PosInvoicingFel;

use EmizorIpx\PosInvoicingFel\Console\Commands\HomologateDemoProducts;
use EmizorIpx\PosInvoicingFel\Console\Commands\SyncBranches;
use EmizorIpx\PosInvoicingFel\Console\Commands\SyncParametrics;
use EmizorIpx\PosInvoicingFel\Console\Commands\SyncSinProducts;
use EmizorIpx\PosInvoicingFel\Console\Commands\TestSendMail;
use EmizorIpx\PosInvoicingFel\Providers\PosInvoicingFelEventServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        $this->loadRoutesFrom(__DIR__."/Routes/web.php");

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

        // VIEWS
        $this->loadViewsFrom(__DIR__ . "/Resources/Views", "posinvoicingfel");
        // $this->publishes([__DIR__.'/Resources/orders' => resource_path('views/orders/'),]);
        //assets
        $this->publishes([__DIR__.'/Resources/assets' => public_path('vendor/posinvoicingfel'),__DIR__.'/Resources/Views/orders' => resource_path('views/orders/')], 'public');

        # CONFIG FILE
        $this->publishes([
            __DIR__."/Config/posinvoicingfel.php" => config_path('posinvoicingfel.php')
        ]);

        $this->mergeConfigFrom(__DIR__.'/Config/posinvoicingfel.php', 'posinvoicingfel');

        Blade::componentNamespace('PosInvoicingFel\\Views\\Components', 'posinvoicingfel');

        // LOAD COMMANDS

        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncParametrics::class,
                SyncSinProducts::class,
                HomologateDemoProducts::class,
                TestSendMail::class,
                SyncBranches::class
            ]);
        }
    }
}
