<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\Bitfumes\Blogg\Models\Category::class, function (Faker $faker) {
    $category = "{$faker->word} {$faker->word}";
    return [
        'name' => $category,
        'slug' => str_slug($category)
    ];
});
