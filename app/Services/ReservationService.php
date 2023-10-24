<?php
namespace App\Services;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\TableListResource;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationService
{
    /**
     * Check if a table is available during a certain datetime for a given number of guests.
     *
     * @param date $datetime The datetime to check.
     * @param int $guests The number of guests to check.
     *
     * @return array List of available tables.
     */

    public function checkAvailability($from_time,$to_time, $guests){

        try {
            $allTables = Table::all();

            $availableTables = [];

            foreach ($allTables as $table) {

                $isTableAvailable = !Reservation::where('table_id', $table->id)
                    ->where('to_time', '>=', $from_time)
                    ->where('from_time', '<=', $to_time)
                    ->exists();

                $isCapacitySufficient = $guests <= $table->capacity;

                if ($isTableAvailable && $isCapacitySufficient) {

                    $availableTables[] = $table;
                }
            }

            return $availableTables;
        } catch (\Throwable $th) {
            Log::error($th);
            return apiResponse(
                false,
                'something went wrong',
                500,
            );
        }
        
     

    }

    /**
     * Check if a certain table is available during a certain datetime.
     *
     * @param date $datetime The datetime to check.
     * @param int $tableId The id of the table.
     *
     * @return bool.
     */

    private function checkTableAvailable($from_time, $to_time, $tableId)
    {
        try {
            $isTableAvailable = Reservation::where('table_id', $tableId)
                    ->where('to_time', '>=', $from_time)
                    ->where('from_time', '<=', $to_time)
                    ->doesntExist();
    
            return $isTableAvailable;
        } catch (\Throwable $th) {
            Log::error($th);
            return apiResponse(
                false,
                'something went wrong',
                500,
            );
        }
 
    }

    /**
     * Store a newly created reservation in the database.
     *
     * @param string $datetime The datetime for the reservation.
     * @param int $tableId The ID of the table.
     *
     * @return \Illuminate\Http\JsonResponse The API response with a success or error message.
     */

    public function store(Request $request)
    {

        try {
            $tableAvailability = $this->checkTableAvailable($request->from_time, $request->to_time, $request->table_id);
            
            if ($tableAvailability) {
                $reservation = Reservation::create($request->all());
    
                return apiResponse(
                    true,
                    'Your reservation created successfully',
                    201,
                    $reservation,
                );
            }
    
            return apiResponse(
                false,
                'This table is unavailable',
                404,  
            );
            
        } catch (\Throwable $th) {
            Log::error($th);
            return apiResponse(
                false,
                'something went wrong',
                500,
            );
        }
   
    }
}