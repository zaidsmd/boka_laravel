<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Cart;
use App\Models\CartLine;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addLine(Request $request)
    {
        $article = Article::find($request->input('article'));
        if ($article->quantite < $request->input('quantity') ){
            return response('الكمية المطلوبة غير متوفرة', 422);
        }

        if (!$article) {
            return response('لم يتم العثور على المنتج', 400);
        }
        if (session()->get('cart')) {
            $cart = Cart::find(session()->get('cart'));
        } else {
            $cart = Cart::create(['user_id' => $request->user()?->id ?? null]);
            session()->put('cart', $cart->id);
        }
        $cartLigne = CartLine::where('cart_id', $cart->id)->where('article_id', $article->id)->first();
        if ($cartLigne) {
            if ($cartLigne->quantity + ($request->input('quantity') ?? 1) > $article->quantite ){
                return response('الكمية المطلوبة غير متوفرة', 422);
            }
            $cartLigne->update([
                'quantity' => $cartLigne->quantity + ($request->input('quantity') ?? 1),
            ]);
        } else {
            CartLine::create([
                'article_title' => $article->title,
                'article_id' => $article->id,
                'quantity' => $request->input('quantity') ?? 1,
                'cart_id' => $cart->id
            ]);
        }
        return response(['total' => $cart->total,'count'=>$cart->cart_lignes()->sum('quantity'), 'message' => 'تمت إضافة العنصر إلى سلة التسوق']);
    }


    public function cartOffCanvas()
    {
        return view('partials.cart_canvas');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function deleteCartLigne(Request $request)
    {
        $cartLine = CartLine::find($request->input('item'));
        if (!$cartLine) {
            return response('لم يتم العثور على العنصر', 400);
        }
        $cartLine->delete();
        return response(['total' => \cart()->total,'count'=>\cart()->cart_lignes()->sum('quantity'), 'message' => 'تم حذف العنصر بنجاح', 'cart' => view('partials.cart_canvas')->render()]);
    }

    /**
     * Display the specified resource.
     */
    public function updateLineQuantity(Request $request)
    {
        $cartLine = CartLine::where('id', $request->input('item'))->where('cart_id', \cart()->id);
        if (!$cartLine) {
            return response('لم يتم العثور على العنصر', 400);
        }
        if (!is_numeric($request->input('quantity'))) {
            return response('المرجو ادخال كمية صحيحة');
        }
        if ($request->input('quantity') == 0) {
            $cartLine->delete();
            return response(['total' => \cart()->total, 'cart' => view('partials.cart-table', ['cart' => \cart()])->render()]);
        }
        $cartLine->update([
            'quantity' => $request->input('quantity')
        ]);
        return response(['total' => \cart()->total, 'cart' => view('partials.cart-table', ['cart' => \cart()])->render(),'count'=>\cart()->cart_lignes()->sum('quantity')]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function deleteLine(Request $request)
    {
        $cartLine = CartLine::where('id', $request->input('item'))->where('cart_id', \cart()->id);
        if (!$cartLine) {
            return response('لم يتم العثور على العنصر', 400);
        }
        $cartLine->delete();
        return response(['total' => \cart()->total,'count'=>\cart()->cart_lignes()->sum('quantity'), 'cart' => view('partials.cart-table', ['cart' => \cart()])->render()]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCartCity(Request $request)
    {
        $cart = \cart();
        $cart->update(['city'=>$request->input('city')]);
        return response(view('partials.cart-table',compact('cart')));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
