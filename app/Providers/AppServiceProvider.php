<?php

namespace App\Providers;

use App\Models\SubmittedHomework;
use App\Models\User;
use App\Observers\SubmittedHomeworkObserver;
use App\Observers\UsersObserver;
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
