<?php
    
namespace App\Interfaces;

interface CheckoutStrategy {

    public function calculateTotal($orderTotal);

}