<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use App\Strategies\ServiceOnlyCheckout;
use App\Strategies\TaxAndServiceCheckout;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function checkout(Request $request , $orderId)
    {
        if (request('checkoutMethod') === 'tax_and_service') {
            $strategy = new TaxAndServiceCheckout();
        } else {
            $strategy = new ServiceOnlyCheckout();
        }

        $checkout_Service = new checkoutService($strategy);
        return $checkout_Service->checkout($orderId);
    }
}
