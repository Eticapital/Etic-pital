<?php

use App\Models\ProjectTeam;
use Faker\Generator as Faker;

$factory->define(ProjectTeam::class, function (Faker $faker) {
    return [
        'project_id' => function () {
            return factory(\App\Models\Project::class)->create()->id;
        },
        'name' => $faker->name,
        'links' => collect(range(0, $faker->numberBetween(0, 2)))->map(function () use ($faker) {
            return $faker->url;
        }),
    ];
});
