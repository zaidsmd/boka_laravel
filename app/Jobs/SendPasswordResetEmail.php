<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\View;
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

        // Render the email template
        $emailBody = View::make('emails.password_reset_ar', [
            'resetLink' => $resetLink
        ])->render();

        // Send the reset email using SendEmailJob
        SendEmailJob::dispatch(
            $this->email,
            'إعادة تعيين كلمة المرور',
            $emailBody
        );
    }
}
