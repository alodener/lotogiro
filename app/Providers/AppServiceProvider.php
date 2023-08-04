<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // dd(auth()->user());

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Check if we have to change user's lang
        $lang = isset($_GET['lang']) && !empty($_GET['lang']) ? $_GET['lang'] : null;


        if($lang && !empty(\Auth::user())) {
            \Auth::user()->lang = $lang;
            \Auth::user()->save();
        }

        Schema::defaultStringLength(191);
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        Paginator::useBootstrap();
    }
}
