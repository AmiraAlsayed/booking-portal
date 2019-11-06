<?php
namespace App\Services;

use Validator;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;

class UserService extends BaseService {

    public $repository;
    public $ticketsService;
    public $userTicketsService;

    /**
     * UserService constructor.
     * @param UsersRepository $repository
     * @param UserTicketsService $userTicketsService
     * @param TicketsService $ticketsService
     */
    public function __construct(UsersRepository $repository, UserTicketsService $userTicketsService, TicketsService $ticketsService)
    {
        $this->repository = $repository;
        $this->ticketsService = $ticketsService;
        $this->userTicketsService = $userTicketsService;
    }


    /**
     * display the user ticket booking form
     * @return array
     */
    public function displayBookingForm() {
        $availableTickets = $this->ticketsService->all();
        $allTickets = [];
        foreach ($availableTickets as $ticket) {
            $allTickets[$ticket->id] =[ $ticket->name .' for '. $ticket->price . $ticket->currency,
            $this->userTicketsService->repository->countBookedTickets($ticket->id)];
        }
       return $data = [
            "availableTickets" => $allTickets,
        ];
    }

    /**
     * handle the user booking process
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\UserBookingLimitException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function bookUserTicket(Request $request) {
        $validator = Validator::make($request->all(), $this->repository->getModel()::$createRules, $this->repository->getModel()::$createRulesMessages);
        if ($validator->fails()) {
            return redirect('/booking')
                ->withErrors($validator)
                ->withInput();
        }
        $user = $this->repository->getModel()->where('email', $request->get('email'))->first();
        if (! $user){
            $user = $this->create($request);
        }
        $this->userTicketsService->bookUserTickets($user->id, $request->get('ticket'));
    }
}
