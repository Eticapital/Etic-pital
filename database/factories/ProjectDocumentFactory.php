<?php

use App\Models\ProjectDocument;
use Faker\Generator as Faker;

$factory->define(ProjectDocument::class, function (Faker $faker) {
    $icon_parser = new \App\Extensions\MimeIconParser();
    // De preferencia una extensión que tenga un ícono entre la lista de íconos
    $extension = collect(['png', 'docx', 'pdf', 'jpg', 'png', 'pptx', 'jpg', 'png'])->random();
    $mime = ($mime = $icon_parser->getMimeByExtension($extension)) ? $mime : null;

    $client_name = $faker->sentence(2) . $extension;
    $size_kb = $faker->numberBetween(100, 500);
    $size = $size_kb * 1024;
    $file = \Illuminate\Http\UploadedFile::fake()->create($client_name, $size_kb);

    if (is_media($file)) {
        $file_name = basename($file->store('projects/media', ['disk' => 'public']));
    } else {
        $file_name = basename($file->store('documents', ['disk' => 'local']));
    }

    $extension =  pathinfo($file_name, PATHINFO_EXTENSION);

    $category = collect(['company', 'key', 'extra'])->random();

    return [
        'project_id' => function () {
            return factory(\App\Models\Project::class)->create()->id;
        },
        'name' => $client_name,
        'description' => $faker->boolean ? $faker->sentence : null,
        'category' => $category,
        'file_name' => $file_name,
        'size' => $size,
        'extension' => $extension,
        'mime' => $mime,
        'is_public' => $faker->boolean(30),
    ];
});
