<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    // Show the form for resetting the password.
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Handle a password reset request.
    public function reset(Request $request)
    {
        $this->validator($request->all())->validate();

        $response = Password::reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
            ? redirect()->route('my-account')->with('status', trans($response))
            : back()->withErrors(['email' => trans($response)]);
    }

    // Get a validator for an incoming reset request.
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
    }

    // Get the credentials for the request.
    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    // Reset the given user's password.
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        Auth::login($user); // Log in the user
    }


}
