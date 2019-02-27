<?php

namespace Bitfumes\Blogg\Listeners;

use Bitfumes\Blogg\Events\BlogVisited;

class BlogVisitedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BlogVisited  $event
     * @return void
     */
    public function handle(BlogVisited $event)
    {
        $key = app()->environment('testing') ? 'testing_blogs' : 'blogs';
        $event->blog->visit($key)->record();
    }
}
