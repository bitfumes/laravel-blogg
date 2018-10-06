<?php

namespace Bitfumes\Blogg\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'             => $this->title,
            'body'              => $this->body,
            'path'              => $this->path(),
            'image_path'        => $this->image_path,
            'thumb_path'        => $this->thumb_path,
            'published_at'      => $this->published_at->diffForHumans()
        ];
    }
}
