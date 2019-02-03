<?php

namespace Bitfumes\Blogg\Listeners;

use Bitfumes\Blogg\Events\UploadImage;
use Bitfumes\Blogg\Events\UploadImageEvent;

class UploadImageListener
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
     * @param  UploadImage  $event
     * @return void
     */
    public function handle(UploadImageEvent $event)
    {
        $blog     = $event->blog;
        $image    = $event->image;
        $oldImage = $blog->getMedia('feature')->count() > 0 ? $blog->getMedia('feature')[0]->getUrl() : null;
        if ($image && ($oldImage != $image)) {
            $blog->clearMediaCollection('feature')
                ->addMediaFromBase64($image)
                ->toMediaCollection('feature', config('blogg.storage.disk'));
        }
    }
}
