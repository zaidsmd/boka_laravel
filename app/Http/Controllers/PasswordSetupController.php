<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class PasswordSetupController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'email_reg' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'first_name' => null,
            'last_name' => null,
            'email' => $request->email_reg,
            'password' => Hash::make('dummy'), // Placeholder password
        ]);

        // Generate a token for the password setup link
        $token = Str::random(60);
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $setupUrl = url('/set-password/' . $token);

        // Send the registration email
        Mail::send('emails.registration', ['setupUrl' => $setupUrl], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Set Your Password');
        });

        return redirect()->back()->with('status', 'تم التسجيل بنجاح! يرجى التحقق من بريدك الإلكتروني لتعيين كلمة المرور.');
    }
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make('dummy'), // Placeholder password
        ]);

        // Generate a token for the password setup link
        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $setupUrl = url('/set-password/' . $token);

        // Send the registration email
        Mail::send('emails.registration', ['setupUrl' => $setupUrl], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Set Your Password');
        });

        return $user;
    }
    public function showForm($token)
    {
        // Validate the token (ensure it matches a user and has not expired)
        return view('auth.set-password', ['token' => $token]);
    }

    public function setPassword(Request $request)
    {
        // Define custom validation messages in Arabic
        $messages = [
            'token.required' => 'رمز التحقق مطلوب.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.confirmed' => 'تأكيد كلمة المرور لا يتطابق.',
            'password.min' => 'يجب أن تكون كلمة المرور على الأقل 8 أحرف.',
        ];

        // Validate the request with custom messages
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ], $messages);

        // Find the user by token
        $user = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if (!$user) {
            return Redirect::route('password.set', ['token' => $request->token])
                ->withErrors(['token' => 'رمز التحقق غير صالح أو منتهي الصلاحية.']);
        }

        // Update the user's password
        $user = User::where('email', $user->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            // Delete the token
            DB::table('password_reset_tokens')->where('token', $request->token)->delete();

            // Log the user in
            Auth::login($user);

            return redirect('/my-account')->with('status', 'تم تعيين كلمة المرور بنجاح!');
        }

        return Redirect::route('password.set', ['token' => $request->token])
            ->withErrors(['token' => 'لم نتمكن من تعيين كلمة المرور.']);
    }


}
