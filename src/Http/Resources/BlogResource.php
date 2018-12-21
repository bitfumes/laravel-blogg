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
        return [
            $this->mergeWhen(request('editing'), ['id'  => $this->id]),
            'title'                => $this->title,

            'body'                 => request('editing') ? $this->body : Markdown::convertToHtml($this->body),

            'path'                 => $this->path(),
            'slug'                 => $this->slug,
            'category'             => new CategoryResource($this->category),
            'tags'                 => new TagCollection($this->tags),
            'user'                 => new UserResource($this->user),
            'likeCounts'           => $this->countLikes(),
            'isLiked'              => !!$this->isLiked(),
            'image_path'           => $this->image_path,
            'thumb_path'           => $this->thumb_path,
            'published_at'         => $this->published ? $this->updated_at->diffForHumans() : null
        ];
    }
}
