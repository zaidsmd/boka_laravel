<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'city'
    ];

    function cart_lignes(): HasMany
    {
        return $this->hasMany(CartLine::class);
    }
    function getTotalAttribute(){
        return $this->cart_lignes()->join('articles','article_id','=','articles.id')->selectRaw('SUM(quantity * IFNULL(articles.sale_price, articles.price)) as total_cart')->first()->total_cart ;
    }
}
