<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPasswordResetEmail implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $email;
    protected $token;

    /**
     * Create a new job instance.
     *
     * @param  string  $email
     * @param  string  $token
     * @return void
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // Generate the reset link
        $resetLink = url('/password/reset/' . $this->token);

        // Send the reset email using a custom Blade template
        Mail::send('emails.password_reset_ar', ['resetLink' => $resetLink], function ($message) {
            $message->to($this->email)
                ->subject('إعادة تعيين كلمة المرور');
        });
    }
}
