<?php

namespace App\Http\Controllers;

use App\Services\TicketsService;
use App\Services\UserService;
use App\Services\UserTicketsService;
use App\User;
use Illuminate\Http\Request;
use Validator;

/**
 * Class UsersBookingController
 * @package App\Http\Controllers
 */
class UsersBookingController extends AbstractController
{

    /**
     * UsersBookingController constructor.
     * @param Request $request
     * @param UserService $userService
     * @param TicketsService $ticketsService
     * @param UserTicketsService $userTicketsService
     */
    public function __construct(
        Request $request,
        UserService $userService,
        TicketsService $ticketsService,
        UserTicketsService $userTicketsService

    ) {
        parent::__construct($request);
        $this->userService = $userService;
        $this->ticketsService = $ticketsService;
        $this->userTicketsService = $userTicketsService;
    }


    /**
     * display booking form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function displayBookingForm() {
        $data = $this->userService->displayBookingForm();
        return view("booking", $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveBookingData(Request $request) {
        $validator = Validator::make($request->all(), User::$createRules, User::$createRulesMessages);
        if ($validator->fails()) {
            return redirect('/booking')
                ->withErrors($validator)
                ->withInput();
        }
        try{
            $this->userService->bookUserTicket($request);

        }catch (\Exception $exception){
            return redirect('/booking')->with('error', $exception->getMessage());
        }
        return redirect('/booking')->with('message', 'Your ticket has been successfully booked.');
    }
}
