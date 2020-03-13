<?php

/** @var Factory $factory */
use App\Models\Audit;
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
        'officer_id' => function () {
            return factory(Officer::class)->create()->id;
        },
    ];
});


$factory->define(Audit::class, function () {
    return [
        'auditable_type' => Bike::class,
        'auditable_id' => function () {
            return factory(Bike::class)->create(['officer_id' => null]);
        },
        'payload' => [
            'foo' => 'bar',
            'from' => 'to',
        ],
    ];
});
