<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
   protected $fillable =[
       'first_name', 'last_name', 'city', 'address', 'user_id'
   ];
}
