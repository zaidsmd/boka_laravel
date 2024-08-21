<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
            return redirect()->route('my-account');
        }
        return redirect()->route('my-account')->withErrors([
            'email' => 'البيانات المقدمة لا تتطابق مع سجلاتنا.',
        ])->onlyInput('email');
    }

    public function logout(){
        Auth::logout();
        session()->regenerate();
        return redirect()->route('my-account');
    }
}
