<?php

namespace App\Http\Controllers;

use App\Services\SmtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SMTPSettingController extends Controller
{
    protected $smtpService;

    public function __construct(SmtpService $smtpService)
    {
        $this->smtpService = $smtpService;
    }
    public function modifier(){
        $smtp_settings = DB::table('smtp_settings')->first(); // Fetch the first record, not all
        // Count pending jobs from the jobs table
        $pending_jobs = DB::table('jobs')->count();
        // Count failed jobs from the failed_jobs table
        $failed_jobs = DB::table('failed_jobs')->count();
        return view('back_office.smtp_settings.modifier', compact('smtp_settings', 'pending_jobs', 'failed_jobs'));
    }

    public function mettre_a_jour(Request $request)
    {
        // Validation des données du formulaire avec des messages personnalisés en arabe
        $validatedData = $request->validate([
            'host' => 'required|string|max:255',
            'port' => 'required|integer',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'encryption' => 'nullable|string|max:50',
            'from_address' => 'nullable|email|max:255',
            'from_name' => 'nullable|string|max:255',
        ], [
            'host.required' => 'حقل الخادم مطلوب.',
            'host.string' => 'يجب أن يكون الخادم نصًا.',
            'host.max' => 'يجب ألا يتجاوز الخادم 255 حرفًا.',

            'port.required' => 'حقل المنفذ مطلوب.',
            'port.integer' => 'يجب أن يكون المنفذ رقمًا صحيحًا.',

            'username.required' => 'حقل اسم المستخدم مطلوب.',
            'username.string' => 'يجب أن يكون اسم المستخدم نصًا.',
            'username.max' => 'يجب ألا يتجاوز اسم المستخدم 255 حرفًا.',

            'password.string' => 'يجب أن تكون كلمة المرور نصًا.',
            'password.max' => 'يجب ألا تتجاوز كلمة المرور 255 حرفًا.',

            'encryption.string' => 'يجب أن يكون التشفير نصًا.',
            'encryption.max' => 'يجب ألا يتجاوز التشفير 50 حرفًا.',

            'from_address.email' => 'يجب أن يكون عنوان البريد الإلكتروني صالحًا.',
            'from_address.max' => 'يجب ألا يتجاوز عنوان البريد الإلكتروني 255 حرفًا.',

            'from_name.string' => 'يجب أن يكون اسم المرسل نصًا.',
            'from_name.max' => 'يجب ألا يتجاوز اسم المرسل 255 حرفًا.',
        ]);
        // Vérifier si une configuration SMTP existe déjà
        $smtpSettings = DB::table('smtp_settings')->first();

        // Si aucune configuration n'existe, en créer une nouvelle
        if (!$smtpSettings) {
            DB::table('smtp_settings')->insert([
                'host' => $validatedData['host'],
                'port' => $validatedData['port'],
                'username' => $validatedData['username'],
                'password' => $validatedData['password'],
                'encryption' => $validatedData['encryption'],
                'from_address' => $validatedData['from_address'],
                'from_name' => $validatedData['from_name'],
            ]);
        } else {
            // Si une configuration existe, la mettre à jour
            DB::table('smtp_settings')->update([
                'host' => $validatedData['host'],
                'port' => $validatedData['port'],
                'username' => $validatedData['username'],
                'password' => $validatedData['password'] ,
                'encryption' => $validatedData['encryption'],
                'from_address' => $validatedData['from_address'],
                'from_name' => $validatedData['from_name'],
            ]);
        }
        return redirect()->route('smtpSettings.modifier')->with('success', 'تم تحديث إعدادات SMTP بنجاح.');
    }



}
