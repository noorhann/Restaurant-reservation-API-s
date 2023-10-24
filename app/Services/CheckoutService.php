<?php

namespace App\Services;

use App\Http\Resources\OrderSingleResource;
use App\Interfaces\CheckoutStrategy;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class CheckoutService
{
    private $checkoutStrategy;

    public function __construct(CheckoutStrategy $strategy)
    {
        $this->checkoutStrategy = $strategy;
    }

    public function checkout($orderId)
    {
        try {

            $order = Order::find($orderId);
            $paid = $this->checkoutStrategy->calculateTotal($order->total);
            $order->paid = $paid;
            $order->save();

            return apiResponse(
                true,
                'Invoice',
                200,
                new OrderSingleResource($order),
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
