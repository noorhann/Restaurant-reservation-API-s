<?php

namespace App\Strategies;

use App\Interfaces\CheckoutStrategy;

class ServiceOnlyCheckout implements CheckoutStrategy
{
    public function calculateTotal($orderTotal)
    {
        $services = $orderTotal * .15;

        return $orderTotal + $services; 
    }
}