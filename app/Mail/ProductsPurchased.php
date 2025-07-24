<?php

namespace App\Mail;

use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class ProductsPurchased extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param Collection $orderItems
     *
     * @return void
     */
    public function __construct(private Collection $orderItems)
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
        $orderNo = $this->orderItems->first()->order->order_no;

        return new Envelope(
            from: new Address(env("SALES_EMAIL_ADDRESS", "sales@e-budget.jubatus.co.ke"), env("SALES_EMAIL_ADDRESS_NAME", "E-budget Sales Team")),
            subject: 'Products Purchased - Order No: ' . $orderNo,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        $total = $this->orderItems->reduce(function($acc, $curr){
            return $acc + (($curr->item_count ?? 0) * ($curr->price_at_order ?? 0));
        }, 0);

        return new Content(
            view: 'emails.orders.productspurchased',
            with: [
                'orderItems' => $this->orderItems,
                'netTotal' => $total,
            ]
        );
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
