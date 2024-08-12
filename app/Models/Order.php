<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status',
        'total',
        'billing_email',
        'payment_method',
        'user_id',
        'number',
        'shipping_fee'
    ];

    public function lines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function billing_address(){
        return $this->hasOne(OrderAdress::class)->where('type','billing')->first();
    }
    public function shipping_address(){
        $shipping =$this->hasOne(OrderAdress::class)->where('type','shipping')->first();
        if (!$shipping){
            return $this->billing_address();
        }
        return  $shipping;
    }
}
