<?php

use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    $videos = collect([
        'https://www.youtube.com/watch?v=tJAwOCKmw1M',
        'https://www.youtube.com/watch?v=J8D6eIj0HTo',
        'https://www.youtube.com/watch?v=3gHJxw_1hsQ',
        'https://www.youtube.com/watch?v=Oca09bEDtuM',
        'https://www.youtube.com/watch?v=6QBrnkO2IgA',
        'https://www.youtube.com/watch?v=gWWaXwr4c_A',
        'https://vimeo.com/9953368',
        'https://vimeo.com/95746815',
        'https://vimeo.com/75736121',
        'https://vimeo.com/145916065',
    ]);

    return [
        'name' => $faker->company . ' ' . $faker->companySuffix,
        'holder' => $faker->name,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'video' => $videos->random(),
        'email' => $faker->email,
        'address' => $faker->email,
        'latitude' => $faker->randomFloat,
        'longitude' => $faker->randomFloat,
    ];
});
