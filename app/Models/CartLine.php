<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartLine extends Model
{
    protected $fillable = [
        'article_title',
        'quantity',
        'article_id',
        'cart_id',
    ];

    function article() {
        return $this->belongsTo(Article::class);
    }
    function cart(){
        return $this->belongsTo(Cart::class);
    }
    function getTotalAttribute() {
        return ($this->article->sale_price ?? $this->article->price) * $this->quantity;
    }
}
