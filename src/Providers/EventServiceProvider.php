<?php

namespace Bitfumes\Blogg\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Bitfumes\Blogg\Events\BlogVisited;
use Bitfumes\Blogg\Listeners\BlogVisitedListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Bitfumes\Blogg\Events\UploadImageEvent' => [
            'Bitfumes\Blogg\Listeners\UploadImageListener',
        ],
        BlogVisited::class => [
            BlogVisitedListener::class
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
