<?php

namespace App\Listeners;

use App\Models\Order;
use App\Events\RefundCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRefundNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RefundCreated $event): void
    {
        $refund = $event->refund;

        $order = Order::find($refund->order_id);

        Mail::to($order->customer_email)->send(new \App\Mail\RefundCreated($refund, $order));
    }
}
