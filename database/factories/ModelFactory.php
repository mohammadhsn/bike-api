<?php

/** @var Factory $factory */
use App\Models\Bike;
use App\Models\Officer;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Officer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(Bike::class, function (Faker $faker) {
    return [
        'licence_number' => $faker->numberBetween(1000, 1000000),
        'type' => 'bmx',
        'color' => $faker->colorName,
        'owner' => $faker->name,
        'description' => $faker->paragraph,
        'theft_at' => $faker->date(),
    ];
});
