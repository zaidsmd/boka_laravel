<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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
        $setupUrl = url('/set-password/' . $this->details['token']);
        Mail::send('emails.registration', ['setupUrl' => $setupUrl], function ($message) {
            $message->to($this->details['email'])
                ->subject('قم بتعيين كلمة المرور الخاصة بك');
        });
    }
}
