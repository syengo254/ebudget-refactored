<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order for {{ $order->user->name }} Created</title>
</head>

<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: .5rem 1rem;
    }

    @media screen and (max-width: 400px) {
        td {
            padding: .2rem .5rem;
            font-size: .9rem;
        }
    }
</style>

<body>
    <main>
        Hello {{ $order->user->name }},
        <p>
            Your order has been created and shall be delivered on {{ $order->expected_delivery_date }}.
        </p>
        <div>
            <h4>Order Summary</h4>
            <p><i>Total items ({{ $order->orderItems->count() }})</i></p>
            <table>
                <thead>
                    <tr>
                        <th>Item</td>
                        <th>Quantity</td>
                        <th>Total Price</td>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->item_count }}</td>
                        @php
                        $fmt = new \NumberFormatter( 'en_KE', \NumberFormatter::CURRENCY );
                        $amt = $fmt->format($item->price_at_order * $item->item_count);
                        @endphp
                        <td style="text-align: right;">{{ $amt }}</td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td style="font-weight:bold; text-align:right; padding-inline: 1rem;" colspan="2">Total</td>
                        <td style="font-weight:bold; text-align: right;">{{ $fmt->formatCurrency($order_total, "KES")}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <p>
            Kind regards, <br/>
            E-budget Team
        </p>
    </main>
</body>

</html>
