<?php

namespace Bitfumes\Blogg\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadImageEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $blog;
    public $image;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($blog, $image)
    {
        $this->blog  = $blog;
        $this->image = $image;
    }
}
