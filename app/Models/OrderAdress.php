<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAdress extends Model
{
    protected $fillable = [
        'type', 'first_name', 'last_name', 'city', 'address', 'phone_number', 'email', 'order_id'
    ];
}
