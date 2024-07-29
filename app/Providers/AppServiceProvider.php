<?php

namespace App\Providers;

use App\View\Composers\YearVisibleComposer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Schema;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        App::setLocale('id');

        Schema::defaultStringLength(191);

        Facades\View::composer('*', YearVisibleComposer::class);
    }
}
