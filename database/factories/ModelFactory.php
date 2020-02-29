<?php

/** @var Factory $factory */
use App\Models\Officer;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Officer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
