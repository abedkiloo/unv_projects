<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
//    return [
//        'name' => $faker->name,
//        'email' => $faker->unique()->safeEmail,
//        'email_verified_at' => now(),
//        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
//        'remember_token' => str_random(10),
//    ];
    return [
        'name' => "Abednego Wambua",
        'email' => "abedxh@gmail.com",
        'email_verified_at' => now(),
        'password' => '$2y$10$wgORQxbY4mjpeHifqZsgFeA09eDot2Wkw0jb7NKqpMkCZIK4QGZ/O', // abedkiloo
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Country::class, function (Faker $faker) {
    ;
    return [
        'country_name' => $faker->country,
    ];
});
$factory->define(App\Disbursment::class, function (Faker $faker) {
    ;
    return [
        'amount' => $faker->randomNumber(2),
        'phase_id' => $faker->randomNumber(2),
        'project_id' => $faker->randomNumber(2),
    ];
});


$factory->define(App\Projects::class, function (Faker $faker) {
    return [
        'project_ref' => $faker->name,
        'project_title' => $faker->realText(),
        'date_of_gcf' => now(),
        'start_date' => $faker->dateTimeBetween('+0 days', '+2 years'),
        'implementing_office' => $faker->address,
        'duration' => str_random(12),
        'amount' => "abedxh@gmail.com",
        'end_date' => $faker->dateTimeBetween('+0 days', '+2 years'),
        'country_id' => str_random(4),
        'disbursement_id' => str_random(2),
//            function () {
//            return factory(App\Disbursment::class)->create()->id;
//        },
        'readiness_id' => str_random(2),
//    function () {
//            return factory(App\ReadinessType::class)->create()->id;
//        },
        'readiness_or_nap' => str_random(2),
        'status_id' => str_random(2),
    ];
});
