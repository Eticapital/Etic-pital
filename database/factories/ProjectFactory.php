<?php

use App\Models\Project;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Zttp\Zttp;

$factory->define(Project::class, function (Faker $faker) {
    $owner = factory(\App\User::class)->create();

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


    $cover = (string) Zttp::get('http://placeimg.com/854/480/any')->getBody();
    $image = Image::make($cover);
    $image_name = $faker->uuid . '.jpg';
    Storage::disk('public')->put('projects/images/' . $image_name, $image->stream());

    // $about_us = (string) \Zttp\Zttp::get('http://loripsum.net/api/3/short/ul')->getBody();
    // collect(\App\Models\Project::$images['cover']['sizes'])->each(function ($size) use ($image, $slug) {
    //     list($width, $height) = str_contains($size, ':') ? explode(':', $size) : [$size, $size];
    //     $image = $image->fit($width, $height, function ($constraint) {
    //         $constraint->upsize();
    //     });
    //     $image_name = $slug . '@' . $width . '.jpg';
    //     \Storage::put('projects/covers/' . $image_name, $image->stream());
    // });
    //
    $has_interested_investor = $faker->boolean;


    return [
        'owner_id' => $owner->id,
        'name' => $faker->company . ' ' . $faker->companySuffix,
        'holder' => $faker->name,
        'holder_links' => collect(range(0, $faker->numberBetween(0, 2)))->map(function () use ($faker) {
            return $faker->url;
        }),
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'image' => $image_name,
        'video' => $videos->random(),
        'email' => $faker->email,
        'address' => $faker->email,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,

        'description' => collect($faker->paragraphs($faker->numberBetween(1, 3)))->implode("\n"),
        'opportunity' => collect($faker->paragraphs($faker->numberBetween(1, 3)))->implode("\n"),
        'competition' => collect($faker->paragraphs($faker->numberBetween(1, 3)))->implode("\n"),

        // company_documents

        'links' => collect(range(0, $faker->numberBetween(0, 2)))->map(function () use ($faker) {
            return $faker->url;
        }),

        // sectors

        'stage_id' => $faker->numberBetween(1, 3),
        'business_model' => collect($faker->paragraphs($faker->numberBetween(1, 3)))->implode("\n"),

        'previous_capital' => $faker->numberBetween(100000 * 100, 10000000 * 100),
        'total_sales' => $faker->numberBetween(100000 * 100, 10000000 * 100),
        'round_size' => $faker->numberBetween(100000 * 100, 10000000 * 100),
        'minimal_needed' => $faker->numberBetween(100000 * 100, 10000000 * 100),

        'has_interested_investor' => $has_interested_investor,
        'interested_investor_name' => $has_interested_investor ? $faker->name : '',

        'expected_sales_year_1' => $faker->numberBetween(100000 * 100, 10000000 * 100),
        'expected_sales_year_2' => $faker->numberBetween(100000 * 100, 10000000 * 100),
        'expected_sales_year_3' => $faker->numberBetween(100000 * 100, 10000000 * 100),

        'is_featured' => $faker->boolean,
        'published_at' => $faker->boolean(80) ? Carbon::now() : null,

        // key_documents
        // extra_documents
    ];
});

