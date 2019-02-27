<?php

namespace Bitfumes\Blogg\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use GrahamCampbell\Markdown\Facades\Markdown;

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
        $userResource       = config('blogg.resource.user');
        $tagCollection      = config('blogg.resource.tagCollection');
        $categoryResource   = config('blogg.resource.category');
        return [
            $this->mergeWhen(request('editing'), ['id'  => $this->id]),
            'title'                => $this->title,

            'body'                 => request('editing') ? $this->body : Markdown::convertToHtml($this->body),

            'path'                 => $this->path(),
            'slug'                 => $this->slug,
            'category'             => new $categoryResource($this->category),
            'tags'                 => new $tagCollection($this->tags),
            'user'                 => new $userResource($this->user),
            'visits'               => $this->visit('blogs')->count(),
            'likeCounts'           => $this->countLikes(),
            'isLiked'              => !!$this->isLiked(),
            'image_path'           => $this->image_path,
            'thumb_path'           => $this->thumb_path,
            'published_at'         => $this->published ? $this->updated_at->diffForHumans() : null
        ];
    }
}
