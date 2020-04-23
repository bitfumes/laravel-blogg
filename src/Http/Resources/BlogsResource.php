<?php

namespace Bitfumes\Blogg\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $categoryResource  = config('blogg.resources.category');
        return [
            $this->mergeWhen(request('editing'), ['id'  => $this->id]),
            'title'                => $this->title,
            'path'                 => $this->path(),
            'slug'                 => $this->slug,
            'category'             => ['name' => $this->category->name, 'slug' => $this->category->slug, 'theme' => $this->category->theme],
            'likeCounts'           => $this->countLikes(),
            'image'                => $this->image ? "{$this->image}.jpg" : '',
            'thumb'                => $this->image ? "{$this->image}_thumb.jpg" : '',
            'published_at'         => $this->published ? $this->updated_at->diffForHumans() : null,
        ];
    }
}
