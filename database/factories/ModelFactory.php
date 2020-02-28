<?php

/** @var Factory $factory */


use App\Models\Officer;
use Illuminate\Database\Eloquent\Factory;
use Faker\Generator as Faker;

$factory->define(Officer::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
