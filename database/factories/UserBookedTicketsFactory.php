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
$factory->define(App\UserTickets::class, function (Faker\Generator $faker) {

    return [
        'user_id' => function() {
            return factory(\App\User::class)->create()->id;
        },
        'ticket_id' => function() {
            return factory(\App\TicketsCategories::class)->create(
//                ['name' => 'Normal ticket', 'price' => '400', 'currency'=> 'EGP']
                ['name' => 'Student ticket', 'price' => '200', 'currency'=> 'EGP']
            )->id;
        },
    ];
});
