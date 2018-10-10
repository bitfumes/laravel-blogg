<?php

use Faker\Generator as Faker;
use Bitfumes\Blogg\Models\Category;
use Bitfumes\Blogg\Tests\User;

$factory->define(Bitfumes\Blogg\Models\Blog::class, function (Faker $faker) {
    $title = $faker->sentence;
    return [
        'title'             => $title,
        'slug'              => str_slug($title),
        // 'image_path'        => $faker->url,
        'body'              => $faker->paragraph,
        'published_at'      => null,
        'user_id'           => function () {
            return factory(User::class)->create()->id;
        },
        'category_id' => function () {
            return factory(Category::class)->create()->id;
        },
        'series' => 0
    ];
});
