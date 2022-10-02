<?php

namespace App\Providers;

use App\Observers\SubmittedHomeworkObserver;
use App\SubmittedHomework;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

use App\User;
use App\Observers\UsersObserver;

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
        // PROVIDERS
        Paginator::useBootstrap();

        // OBSERVERS
        User::observe(UsersObserver::class);
        SubmittedHomework::observe(SubmittedHomeworkObserver::class);

        // VALIDATORS
        Validator::extend('alpha_space', 'App\Rules\AlphaSpaceRule@passes');
    }
}
