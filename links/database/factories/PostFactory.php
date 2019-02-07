<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => substr($faker->sentence(2), 0, -1),
        'topic' => substr($faker->sentence(2), 0, -1),
        'description' => $faker->paragraph,
    ];
});
