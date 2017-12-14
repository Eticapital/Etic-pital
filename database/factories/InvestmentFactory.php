<?php

use App\Models\Investment;
use Faker\Generator as Faker;

$factory->define(Investment::class, function (Faker $faker) {
    $statuses = collect([Investment::STATUS_NEW, Investment::STATUS_ACCEPTED, Investment::STATUS_REJECTED]);
    return [
        'owner_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'project_id' => function () {
            return factory(\App\Models\Project::class)->create()->id;
        },
        'amount' => $faker->numberBetween(5000 * 100, 50000 * 100),
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'residence' => $faker->city,
        'organization' => $faker->company,
        'investment_status' => $statuses->random(),
    ];
});

