<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        // $loader->alias(\PhpOffice\PhpSpreadsheet\Reader\Csv::class, \App\Vendor\Csv::class);
        // $this->app->bind(\PhpOffice\PhpSpreadsheet\Reader\Csv::class, function ($app) {
        //     return new \App\Readers\MyCSV();
        // });
        $this->app->bind('mycsv', function ($app) {
            return new \App\Vendors\PhpOffice\Csv;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
