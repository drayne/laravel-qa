<?php

use Faker\Generator as Faker;

$factory->define(\App\Question::class, function (Faker $faker) {
    return [
        'title' => rtrim($faker->sentence(rand(5, 10)), '.'),
        'body' => $faker->paragraph(rand(1, 5), true), //true -> string, false -> array
        'views' => $faker->numberBetween(0, 10),
//        'answers_count' => $faker->numberBetween(0, 10),
//        'votes_count' => $faker->numberBetween(-3, 10)
    ];
});
