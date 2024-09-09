<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Cart;
use App\Models\CartLine;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if ($request->get('__action')==='mo' && $request->get('__value')){
                $article = Article::find($request->get('__value'));
                if ($article){
                    if ($article->quantite < 0){
                        $cartRequest = $request->merge(['article'=>$article->id]);
                        $cartController = new CartController();
                         $cartController->addMemberOrder($cartRequest);
                        session()->flash('success','تمت إضافة العنصر إلى الطلبات عند الوصول');
                    }
                }
            }
            return redirect()->route('my-account');
        }
        return redirect()->route('my-account')->withErrors([
            'email' => 'البيانات المقدمة لا تتطابق مع سجلاتنا.',
        ])->withInput($request->except('password'));
    }

    public function logout(){
        Auth::logout();
        session()->regenerate();
        return redirect()->route('my-account');
    }
}
