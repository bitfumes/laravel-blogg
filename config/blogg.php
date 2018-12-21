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
    ]
];
