<?php

namespace App\Providers;

use App\Channel;
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
            $channels = \Cache::rememberForever('channels', function() {
                return Channel::all();
            });
            $view->with('channels', $channels);
        });

        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes'); // laravel 5.4. en laravel 5.5 comando artisan disponible
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()){
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
        //
    }
}
