<?php

namespace App\Actions;

use App\Mail\OrderCreated;
use App\Mail\ProductsPurchased;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class SendOrderEmails
{
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
        $orderItems = $order->orderItems()->with('product', 'order')->get();
        $vendors = $orderItems->pluck('product.store.user')->unique();
        
        foreach ($vendors as $key => $vendor) {
            Mail::to($vendor->email)
                ->queue(
                    new ProductsPurchased(
                        $orderItems->where('product.store.user_id', $vendor->id)
                    )
                );
        }
    }
}
