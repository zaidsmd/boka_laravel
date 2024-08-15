<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShippingAddress extends Model
{
    protected $fillable = [
       'first_name', 'last_name', 'city', 'address', 'order_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
