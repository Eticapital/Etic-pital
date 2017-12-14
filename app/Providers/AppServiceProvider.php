<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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
        Schema::defaultStringLength(191);

        \App\Models\Investment::observe(\App\Observers\InvestmentObserver::class);

        \Illuminate\Pagination\AbstractPaginator::defaultView("pagination::bootstrap-4");

        Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
            return \Illuminate\Support\Facades\Hash::check($value, current($parameters));
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
