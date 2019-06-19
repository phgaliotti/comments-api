<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\Posting;
use App\PostType;

$factory->define(Posting::class, function (Faker $faker) {
    $users = App\User::pluck('id')->toArray();
    $postingTypes = PostType::pluck('id')->toArray();

    return [
        'title' => $faker->sentence,
        'type_id'=> $faker->randomElement($postingTypes),
        'content' => $faker->text,
        'user_id' => $faker->randomElement($users)
    ];
});