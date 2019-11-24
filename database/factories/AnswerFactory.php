<?php

use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraphs(rand(3, 7), true), //true - kao single string
        'user_id' => App\User::pluck('id')->random(), //random id usera koji vec postoji u bazi
        //'user_id' => array_random(\App\User::pluck('id')->all()),  drugi nacin
        'votes_count' => rand(0, 5),
    ];
});
