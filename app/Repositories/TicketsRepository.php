<?php


namespace App\Repositories;

class TicketsRepository extends BaseRepository
{
    /**
     * Define model of the repository
     *
     * @return string
     */
    public function model()
    {
        return 'App\TicketsCategories';
    }
}
