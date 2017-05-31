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
        //\View::share('channels', \App\Channel::all());
        // usar ::share intenta carregar el que es demana abans d'executar DatabaseMigrations,
        // pel que usem View::composer(*)
        
        // \View::composer('threads.create', function($view){
        //     $view->with('channels', \App\Channel::all());
        // });

        \View::composer('*', function($view){ //works for all views
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
