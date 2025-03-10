<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Journal;
use Faker\Generator as Faker;

$factory->define(Journal::class, function (Faker $faker) {
    return [
        'client_id' => function () {
            return factory(Client::class)->create()->id;
        },
        'entry' => $faker->paragraphs(random_int(1, 5), true),
    ];
});
