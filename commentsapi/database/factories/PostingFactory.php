<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\Posting;

$factory->define(Posting::class, function (Faker $faker) {
    $users = App\User::pluck('id')->toArray();
    $postingTypes = ["picture" , "video", "text"];

    return [
        'title' => $faker->sentence,
        'type'=> $faker->randomElement($postingTypes),
        'content' => $faker->text,
        'user_id' => $faker->randomElement($users)
    ];
});