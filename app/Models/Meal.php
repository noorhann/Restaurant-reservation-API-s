<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
