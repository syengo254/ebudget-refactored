<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(protected Order $order)
    {
        //
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address(env("SALES_EMAIL_ADDRESS", "sales@e-budget.jubatus.co.ke"), "E-budget Sales Team"),
            subject: 'Your Order Has Been Created',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $order = Order::query()->where('id', $this->order->id);
        $order = $order->with('user', 'orderItems')->withWhereHas('orderItems', function ($query) {
            $query->with('product');
        })->first();

        $orderTotal = $order->orderItems->reduce(function($prev, $val){
            return $prev + ($val->product->price * $val->item_count);
        }, 0);

        return new Content(
            view: 'emails.orders.created',
            with: [
                'order' => $order,
                'order_total' => $orderTotal,
            ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
