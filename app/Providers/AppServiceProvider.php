<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //\View::composer('*', function($view){ //works for all views
        //\View::share('channels', \App\Channel::all());
        //\View::composer('threads.create', function($view){
        \View::composer('threads.create', function($view){
            $view->with('channels', \App\Channel::all());
        });
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
