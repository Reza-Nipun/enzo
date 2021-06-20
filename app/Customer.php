<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    public function customerOrders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
