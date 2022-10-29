<?php

namespace App\Providers;

use App\Models\SubmittedHomework;
use App\Models\User;
use App\Observers\SubmittedHomeworkObserver;
use App\Observers\UsersObserver;
use Blade;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
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
        Blade::directive('menuActive',function($expression) {
            //explode the '$expression' string to the varibles needed
            list($route, $class) = explode(', ', $expression);
            //then we check if the route is the same as the one we are passing.
            return "{{ request()->routeIs({$route}) ? {$class} : '' }}";
        });

        Blade::directive('menuInactive',function($expression) {
            //explode the '$expression' string to the varibles needed
            list($route, $class) = explode(', ', $expression);
            //then we check if the route is the same as the one we are passing.
            return "{{ !request()->routeIs({$route}) ? {$class} : '' }}";
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // PROVIDERS
        Paginator::useBootstrap();

        // OBSERVERS
        User::observe(UsersObserver::class);
        SubmittedHomework::observe(SubmittedHomeworkObserver::class);

        // VALIDATORS
        Validator::extend('alpha_space', 'App\Rules\AlphaSpaceRule@passes');
    }
}
