<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\NewProjectRegistered' => [
            'App\Listeners\NewProjectRegisteredListener',
        ],
        'App\Events\ProjectPublished' => [
            'App\Listeners\ProjectPublishedListener',
        ],
        'App\Events\ProjectRejected' => [
            'App\Listeners\ProjectRejectedListener',
        ],
        'App\Events\ProjectFinished' => [
            'App\Listeners\ProjectFinishedListener',
        ],
        'App\Events\NewProjectInvestment' => [
            'App\Listeners\NewProjectInvestmentListener',
        ],
        'App\Events\NewUserCreatedFromInvestment' => [
            'App\Listeners\NewUserCreatedFromInvestmentListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
