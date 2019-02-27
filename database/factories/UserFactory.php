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
$factory->define(App\Status::class, function (Faker $faker) {
    return [
        'status_name' => $faker->randomElement(['under implementation', 'completed', 'on hold'])
    ];
});
$factory->define(App\PhaseOfDisbursment::class, function (Faker $faker) {
    return [
        'phase_name' => $faker->randomElement(['First  Phase', 'Second Phase', 'Third Phase'])
    ];
});


$factory->define(App\ReadinessType::class, function (Faker $faker) {
    ;
    return [
        'readiness_type_name' => $faker->randomElement(['NAP', 'Capacity Building', 'REDD+', 'FI/TNA/other']),
    ];
});

$factory->define(App\Disbursment::class, function (Faker $faker) {
    ;
    return [
        'amount' => $faker->randomNumber(2),
        'phase_id' =>
            function () {
                return factory(App\PhaseOfDisbursment::class)->create()->id;
            },
        'project_id' => $faker->randomNumber(2),
    ];
});

$factory->define(App\Projects::class, function (Faker $faker) {
    return [
        'project_ref' => $faker->name,
        'project_title' => $faker->sentence(),
        'date_of_gcf' => now(),
        'start_date' => $faker->dateTimeBetween('+0 days', '+2 years'),
        'implementing_office' => $faker->address,
        'duration' => $faker->randomNumber(),
        'amount' => $faker->randomNumber(),
        'end_date' => $faker->dateTimeBetween('+0 days', '+2 years'),
        'country_id' => function () {
            return factory(App\Country::class)->create()->id;
        },
        'disbursement_id' =>
            function () {
                return factory(App\Disbursment::class)->create()->id;
            },
        'readiness_id' =>
            function () {
                return factory(App\ReadinessType::class)->create()->id;
            },
        'readiness_or_nap' => str_random(2),
        'status_id' =>
            function () {
                return factory(App\Status::class)->create()->id;
            },
    ];
});
