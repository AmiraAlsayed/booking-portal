<?php
namespace App\Services;

use App\Exceptions\UserBookingLimitException;
use Illuminate\Validation\ValidationException;
use Validator;
use App\Repositories\UserTicketsRepository;

class UserTicketsService extends BaseService {

    public $repository;

    /**
     * TicketsService constructor.
     * @param UserTicketsRepository $repository
     */
    public function __construct(UserTicketsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     * @param $id
     * @param $ticketsId
     * @throws UserBookingLimitException
     * @throws ValidationException
     */
    public function bookUserTickets($id, $ticketsId) {
        foreach ( $ticketsId as $ticketId => $ticketName){
            $numberOfBookedTickets = $this->repository->countBookedTickets($ticketId);
            if ($numberOfBookedTickets > 200) {
                throw new UserBookingLimitException('Sorry, all the '.$ticketName.' are sold out.');
            }
            $userTickets = $this->repository->getModel()->where('user_id', $id)->where('ticket_id', $ticketId)->first();
            if ($userTickets){
               throw new UserBookingLimitException('Sorry, You have previously booked '.$ticketName. ' with this email.');
            }
            $data = ['user_id' => $id,
                     'ticket_id' => $ticketId
            ];
            $validator = Validator::make($data, $this->repository->getModel()::$createRules, $this->repository->getModel()::$createRulesMessages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            $this->repository->create($data);
        }
    }
}
