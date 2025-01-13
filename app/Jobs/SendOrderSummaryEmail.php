<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendOrderSummaryEmail implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send the order summary email


        // Send order summary email to the user
        Mail::send('emails.order_summary_ar', ['order' => $this->order], function ($message) {
            $message->to($this->order->billing_email)
                ->subject('ملخص الطلب');
        });

        // Retrieve all admins with `notifiable = true`
        $notifiableAdmins = \App\Models\User::where('role', 'admin')->where('notifiable', true)->get();

        // Send notification email to each admin
        foreach ($notifiableAdmins as $admin) {
            Mail::send('emails.new_order_ar', ['order' => $this->order], function ($message) use ($admin) {
                $message->to($admin->email)
                    ->subject('إشعار طلب جديد');
            });
        }
    }
}
