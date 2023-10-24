<?php

namespace App\Strategies;

use App\Interfaces\CheckoutStrategy;

class TaxAndServiceCheckout implements CheckoutStrategy
{
    public function calculateTotal($orderTotal)
    {
        $taxes = $orderTotal * .14 ;
        $services = $orderTotal * .2 ;

        return $orderTotal + $taxes + $services ; 
    }
}