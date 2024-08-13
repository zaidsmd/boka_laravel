<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $fillable = [
        'article_id',
        'article_title',
        'price',
        'quantity',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}