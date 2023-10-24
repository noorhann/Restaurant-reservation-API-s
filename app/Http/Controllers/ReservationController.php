<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckAvailabiltyRequest;
use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\TableListResource;
use App\Services\ReservationService;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * Store a newly created reservation in database.
     *
     * @param  \App\Http\Requests\StoreReservationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReservationRequest $request)
    {
        return $this->reservationService->store($request);
    }

    /**
     * check if a table available duraing a certain certain datetime for a given number of guests.
     *
     * @param  \App\Http\Requests\CheckAvailabiltyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function checkAvailability(CheckAvailabiltyRequest $request)
    {
        $availableTables = $this->reservationService->checkAvailability($request->from_time,$request->to_time, $request->guestsNo);
        
        if ($availableTables) 
        {
            return apiResponse(
                true,
                'There are tables available', 
                200,
                TableListResource::collection($availableTables)
            );
        } 
        else {
            return apiResponse(
                false,
                'No tables are available.',
                404,
            );
        }

    }

}
