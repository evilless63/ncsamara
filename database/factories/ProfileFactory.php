<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [

        'name' => $faker->name,
        'phone' =>'89001112233',
        'about' => $faker->realText(),
        'address' => $faker->address,
        'address_x' => '1',
        'address_y' => '1',
        'working_hours_from' => random_int(1, 24),
        'working_hours_to' => random_int(1, 24),
        'working_24_hours' => random_int(0,1),

        'main_image' => str_replace(' ', '', strtolower($faker->name)).'.jpg',

        'apartments' => random_int(0,1),
        'check_out' => random_int(0,1),

        'age' => random_int(18,36),
        'boobs' => random_int(1,10),
        'height' => random_int(160,185),
        'weight' => random_int(48,70),

        'one_hour' => random_int(2000, 6000),
        'two_hour' => random_int(4000, 12000),
        'all_night' => random_int(12000, 40000),

        'is_published' => random_int(0,1),
        'verified' => random_int(0,1),
        'is_archived' => random_int(0,1),
    ];
});

