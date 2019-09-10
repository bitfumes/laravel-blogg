<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Bitfumes\Blogg\Tests\User;
use Bitfumes\Blogg\Models\Category;

$factory->define(Bitfumes\Blogg\Models\Blog::class, function (Faker $faker) {
    $title = $faker->sentence;
    return [
        'title'             => $title,
        'slug'              => Str::slug($title),
        // 'image_path'        => $faker->url,
        'body'              => $faker->paragraph,
        'published'         => false,
        'user_id'           => function () {
            return factory(User::class)->create()->id;
        },
        'category_id' => function () {
            return factory(Category::class)->create()->id;
        },
    ];
});
