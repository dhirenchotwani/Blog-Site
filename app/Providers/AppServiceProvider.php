<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//this is needed to set default values of fields of tables when we use migrate option in cmd
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //setting default value of type VARCHAR (191 is the max supported by artisan)
		Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
