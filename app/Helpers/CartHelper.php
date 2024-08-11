<?php

use App\Models\Cart;

/**
 * @return Cart
 */
function cart(): Cart
{
    $cart = null;

    if (session()->has('cart')) {
        $cart = Cart::find(session()->get('cart'));
    }

    if (!$cart && auth()->check()) {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()], ['user_id' => auth()->id()]);
    }

    if (!$cart) {
        $cart = Cart::create(['user_id' => auth()->id() ?? null,]);
    }
    session()->put('cart', $cart->id);
    return $cart;
}
