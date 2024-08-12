<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Cart;
use Illuminate\Http\Request;

class ShopViewsController extends Controller
{
    public function myAccount(Request $request){
        $auth =  $request->user();
        return view('account',compact('auth'));
    }
    public function home(Request $request){
        $latest = Article::limit(4)->get();
        return view('home',compact('latest'));
    }
    public function cart(Request $request){
        $cart = cart();
        return view('cart',compact('cart'));
    }

    public function checkout(){
        return view('checkout');
    }
}
