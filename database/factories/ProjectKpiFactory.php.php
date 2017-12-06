<?php

use App\Models\ProjectKpi;
use Faker\Generator as Faker;

$factory->define(ProjectKpi::class, function (Faker $faker) {
    $times = collect(['Un año', 'Dos años', 'Un mes', '2 semanas']);
    return [
        'project_id' => function () {
            return factory(\App\Models\Project::class)->create()->id;
        },
        'time' => $times->random(),
        'description' => collect($faker->paragraphs($faker->numberBetween(1, 2)))->implode("\n"),
    ];
});
