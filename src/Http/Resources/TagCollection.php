<?php

namespace Bitfumes\Blogg\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TagCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $tagResource = config('blogg.resource.tag');
        $collection  = $tagResource::collection($this->collection);
        return [
            'data' => $collection
        ];
    }
}
