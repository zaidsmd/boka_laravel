<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Jobs\SendPasswordResetEmail;

use Illuminate\Support\Facades\DB;
class PasswordResetController extends Controller
{
    // Show the form for resetting the password.
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset', ['token' => $token]);

//        return view('auth.reset')->with(
//            ['token' => $token, 'email' => $request->email]
//        );
    }

    // Handle a password reset request.
    public function reset(Request $request)
    {
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

        // Find the token in the database
        $tokenData = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if (!$tokenData) {
            return redirect()->route('password.reset', ['token' => $request->token])
                ->withErrors(['token' => 'رمز التحقق غير صالح أو منتهي الصلاحية.']);
        }

        // Find the user and update the password
        $user = User::where('email', $tokenData->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            // Delete the token
            DB::table('password_reset_tokens')->where('token', $request->token)->delete();

            // Log the user in
            Auth::login($user);
            session()->flash('success','تم تعيين كلمة المرور بنجاح!');
            return redirect('/my-account')->with('status', 'تم تعيين كلمة المرور بنجاح!');
        }

        return redirect()->route('password.reset', ['token' => $request->token])
            ->withErrors(['token' => 'لم نتمكن من تعيين كلمة المرور.']);
    }


    public function showLinkRequestForm()
    {
        return view('auth.forgot_email');

    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email address
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحاً.',
        ]);

        // Check if the email exists in the users table
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'لا يوجد حساب مسجل بهذا البريد الإلكتروني.']);
        }

        // Generate a password reset token
        $token = Str::random(60);

        // Store the token in the password_resets table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        // Dispatch the job to send the email
        SendPasswordResetEmail::dispatch($request->email, $token);

        return back()->with('status', 'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.');
    }




}
