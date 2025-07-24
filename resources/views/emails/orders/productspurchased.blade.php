 @php
 $fmt = new \NumberFormatter( 'en_KE', \NumberFormatter::CURRENCY );
 @endphp
<x-email>
    <x-slot:title>Product Purchased From {{ $orderItems->first()->product->store->user->name }}</x-slot:title>

    <p>Hello {{ $orderItems->first()->product->store->user->name }},</p>
    <p>Some of your products on our website have been purchased by one of our customers. Please find the details below:</p>
        <table>
        <thead>
            <tr>
                <th style="text-align: left;">Product</th>
                <th>Qty</th>
                <th>Purchase Price</th>
                <th>Total Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderItems as $orderItem)
            <tr>
                <td>{{ $orderItem->product->name }}</td>
                <td>{{ $orderItem->item_count }}</td>
                <td>{{ $fmt->format($orderItem->price_at_order) }}</td>
                <td style="text-align: right;">{{ $fmt->format($orderItem->price_at_order * $orderItem->item_count) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">TOTALS</th>
                <td>
                    {{ $fmt->format($netTotal) }}
                </td>
            </tr>
        </tfoot>
    </table>
    <div>
        <p>
            For smooth pickup by our delivery team, please ensure that these products are available by 
            <strong>
                {{ $longDateString = date("l, F j, Y", strtotime($orderItems->first()->order->expected_delivery_date)) }}.
            </strong> 
            <br />
            <br />
            <i>If this is not possible, please contact our sales team within 12 hours.</i>
        </p>
    </div>
    <p>Thank you for your business.</p>
    <p>Best regards,</p>
    <p>The E-budget Team</p>
</x-email>
