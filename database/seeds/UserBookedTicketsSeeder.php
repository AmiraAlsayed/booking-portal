<?php

use Illuminate\Database\Seeder;

class UserBookedTicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\UserTickets::class, 1)->create();
    }
}
