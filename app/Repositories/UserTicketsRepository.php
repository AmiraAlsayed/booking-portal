<?php

namespace App\Repositories;

use App\UserTickets;

class UserTicketsRepository extends BaseRepository
{
    /**
     * Define model of the repository
     *
     * @return string
     */
    public function model()
    {
        return 'App\UserTickets';
    }

    /**
     * count the number of time the ticket has been booked
     * @param $ticketId
     * @return int
     */
    public function countBookedTickets($ticketId) {
        return UserTickets::where('ticket_id', $ticketId)->count();
    }
}
