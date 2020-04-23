<?php

return [
    'paginate'      => 15,
    'include_views' => false,
    'middleware'    => 'auth',
    'models'        => [
        'user'    => App\User::class,
        'category' => Bitfumes\Blogg\Models\Category::class,
        'tag'     => Bitfumes\Blogg\Models\Tag::class,
    ],
    'resources' => [
        'blog'     => Bitfumes\Blogg\Http\Resources\BlogResource::class,
        'blogs'    => Bitfumes\Blogg\Http\Resources\BlogsResource::class,
        'category' => Bitfumes\Blogg\Http\Resources\CategoryResource::class,
        'user'     => Bitfumes\Blogg\Http\Resources\UserResource::class,
        'tag'      => Bitfumes\Blogg\Http\Resources\TagResource::class,
    ],
    'image'      => [
        'path'       => 'blogs',
        'thumb'      => [
            'width'  => 368,
            'height' => 232,
        ],
    ],
    'storage' => [
        'disk' => 'public',
    ],
];
