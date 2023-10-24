<?php

namespace App\Services;

use App\Http\Resources\MealListResource;
use App\Models\Meal;
use Illuminate\Support\Facades\Log;

class MealService
{
    /**
     * Display a listing of the menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            $meals = Meal::get();

            if($meals)
            {
                return apiResponse(
                    true,
                    'menu items',
                    200,
                    MealListResource::collection($meals),
                );
            }

            
        } 
        catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
