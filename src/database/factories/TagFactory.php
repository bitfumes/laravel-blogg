<?php

use Faker\Generator as Faker;

$factory->define(Bitfumes\Blogg\Models\Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
