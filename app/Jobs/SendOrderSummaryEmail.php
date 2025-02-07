<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\View;
class SendOrderSummaryEmail
{
    use Dispatchable, SerializesModels;

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
        // Render the customer email template
        $customerEmailBody = View::make('emails.order_summary_ar', [
            'order' => $this->order
        ])->render();
        // Send order summary email to the customer
        SendEmailJob::dispatch(
            $this->order->billing_email,
            'ملخص الطلب',
            $customerEmailBody
        );
        // Retrieve all admins with `notifiable = true`
        $notifiableAdmins = \App\Models\User::where('role', 'admin')
            ->where('notifiable', true)
            ->get();
        if ($notifiableAdmins->isNotEmpty()) {
            // Render the admin notification template
            $adminEmailBody = View::make('emails.new_order_ar', [
                'order' => $this->order
            ])->render();
            // Send notification email to each admin
            foreach ($notifiableAdmins as $admin) {
                SendEmailJob::dispatch(
                    $admin->email,
                    'إشعار طلب جديد',
                    $adminEmailBody
                );
            }
        }
    }
}
