<?php
namespace App\Services;


use App\Repositories\TicketsRepository;

class TicketsService extends BaseService {

    public $repository;

    /**
     * TicketsService constructor.
     * @param TicketsRepository $repository
     */
    public function __construct(TicketsRepository $repository)
    {
        $this->repository = $repository;
    }

}
