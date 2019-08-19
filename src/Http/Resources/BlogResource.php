<?php

namespace Bitfumes\Blogg\Http\Resources;

use GrahamCampbell\Markdown\Facades\Markdown;
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
        $tagResource      = config('blogg.resources.tag');
        $categoryResource = config('blogg.resources.category');
        $userResource     = config('blogg.resources.user');
        return [
            $this->mergeWhen(request('editing'), ['id'  => $this->id]),
            'title'                => $this->title,
            'body'                 => request('editing') ? $this->body : Markdown::convertToHtml($this->body),
            'path'                 => $this->path(),
            'slug'                 => $this->slug,
            'category'             => new $categoryResource($this->category),
            'tags'                 => $tagResource::collection($this->tags),
            'user'                 => new $userResource($this->user),
            'likeCounts'           => $this->countLikes(),
            'isLiked'              => !!$this->isLiked(),
            'image'                => $this->image,
            'published_at'         => $this->published ? $this->updated_at->diffForHumans() : null,
        ];
    }
}
