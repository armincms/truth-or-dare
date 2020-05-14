<?php

namespace Armincms\TruthOrDare;
 
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova as LaravelNova; 

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {  
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        LaravelNova::serving(function (ServingNova $event) {
            LaravelNova::resources([
                Nova\Game::class,
                Nova\Stage::class,
                Nova\Theme::class,
                Nova\Player::class,
                Nova\Question::class,
                Nova\Consequence::class,
                Nova\Points::class,
            ]);
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
