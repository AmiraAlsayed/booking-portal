<?php


namespace App\Repositories;

class UsersRepository extends BaseRepository
{
    /**
     * Define model of the repository
     *
     * @return string
     */
    public function model()
    {
        return 'App\User';
    }
}
