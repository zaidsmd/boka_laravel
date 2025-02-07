<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;

class SendRegistrationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function handle()
    {
        // Generate the setup URL
        $setupUrl = url('/set-password/' . $this->details['token']);

        // Render the email template
        $emailBody = View::make('emails.registration', [
            'setupUrl' => $setupUrl
        ])->render();

        // Send the registration email using SendEmailJob
        SendEmailJob::dispatch(
            $this->details['email'],
            'قم بتعيين كلمة المرور الخاصة بك',
            $emailBody
        );
    }
}
