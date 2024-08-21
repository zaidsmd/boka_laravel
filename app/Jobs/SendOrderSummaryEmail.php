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
        Mail::send('emails.order_summary_ar', ['order' => $this->order], function ($message) {
            $message->to($this->order->billing_email)
                ->subject('ملخص الطلب');
        });
    }
}
