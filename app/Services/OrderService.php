<?php

namespace App\Services;

use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderService
{
    /**
     * Display a listing of the menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            
            $total = 0 ;

            $order = Order::create([
                'table_id' => $request['table_id'],
                'customer_id' => $request['customer_id'],
                'reservation_id' => $request['reservation_id'],
                'user_id' => auth()->user()->id,
            ]);

            foreach($request['meal_id'] as $mealId) {
                $meal = Meal::find($mealId);
                if($meal->available_quantity > 0)	
                {
                    $priceAfterDiscount = $meal->price - ($meal->price * ($meal->discount / 100)) ;
                    $total = $total + $priceAfterDiscount;
                    $meal->available_quantity--;
                    OrderDetail::create([
                        'meal_id' => $mealId,
                        'amount_to_pay' => $priceAfterDiscount,
                        'order_id' => $order->id,
                    ]);
                }
                
            }

            $order->total = $total ;
            $order->save();

            return apiResponse(
                true,
                'Your order created successfully',
                201,
                $order,
            );
        } 
        catch (\Throwable $th) {
            Log::error($th);
            return apiResponse(
                false,
                'something went wrong',
                500,
            );
        }
    }
}
