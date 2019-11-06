<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\TicketsCategories::class, function (Faker\Generator $faker, $param) {
    return [
        'name' => $param['name'],
        'price' => $param['price'],
        'currency' =>$param['currency']
    ];
});
