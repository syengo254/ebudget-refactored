<?php

namespace App\Actions;

use App\Mail\OrderCreated;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class SendOrderEmails {
    public function handle(Order $order)
    {
        $this->sendCustomerOrderReceivedEmail($order);
        $this->sendVendorProductsPurchasedEmail($order);
    }

    private function sendCustomerOrderReceivedEmail(Order $order)
    {
        Mail::to($order->user)->queue(new OrderCreated($order));
    }

    private function sendVendorProductsPurchasedEmail(Order $order)
    {
        // we shall first need to group orderitems per vendor so as to send only one email per order to vendor

        // foreach($order->orderItems()->with('product')->get() as $orderItem){
        //     Mail::to($orderItem->product->store->user->email)->queue(new ProductPurchased($orderItem));
        // }
    }
}
