<?php

return [
    'paginate' => 15,
    'thumb'    => [
        'width'   => 368,
        'height'  => 232,
        'sharpen' => 10
    ],
    'models' => [
        'user'    => App\User::class,
        'category'=> Bitfumes\Blogg\Models\Category::class,
        'tag'     => Bitfumes\Blogg\Models\Tag::class
    ],
    'resource' => [
        'user'               => Bitfumes\Blogg\Http\Resources\UserResource::class,
        'blog'               => Bitfumes\Blogg\Http\Resources\BlogResource::class,
        'blogCollection'     => Bitfumes\Blogg\Http\Resources\BlogCollection::class,
        'tag'                => Bitfumes\Blogg\Http\Resources\TagResource::class,
        'tagCollection'      => Bitfumes\Blogg\Http\Resources\TagCollection::class,
        'category'           => Bitfumes\Blogg\Http\Resources\CategoryResource::class,
        'categoryCollection' => Bitfumes\Blogg\Http\Resources\CategoryCollection::class
    ]
];
