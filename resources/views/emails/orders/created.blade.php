 @php
 $fmt = new \NumberFormatter( 'en_KE', \NumberFormatter::CURRENCY );
 @endphp
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Order for {{ $order->user->name }} Created</title>
 </head>

 <style>
     @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

     :root {
         font-family: 'Roboto', sans-serif;

         font-synthesis: none;
         text-rendering: optimizeLegibility;
         -webkit-font-smoothing: antialiased;
         -moz-osx-font-smoothing: grayscale;
     }

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
             Your order has been created and shall be delivered on <strong>{{ $order->expected_delivery_date }}</strong> (latest on: <b>{{ $order->latest_delivery_date }}</b>).
         </p>
         <p>
            <strong>Order Number: </strong>{{ $order->order_no }}
         </p>
         <div>
             <h4>Order Summary</h4>
             <p><i>Total items ({{ $order->order_items_count }})</i></p>
             <table>
                 <thead>
                     <tr>
                         <th>Item</td>
                         <th>Qty</td>
                         <th>Unit Cost</td>
                         <th>Total Price</td>
                     </tr>
                 </thead>

                 <tbody>
                     @foreach ($order->orderItems as $item)
                     <tr>
                         <td>{{ $item->product->name }}</td>
                         <td>{{ $item->item_count }}</td>
                         <td>{{ $fmt->format($item->price_at_order) }}</td>
                         @php
                         $amt = $fmt->format($item->price_at_order * $item->item_count);
                         @endphp
                         <td style="text-align: right;">{{ $amt }}</td>
                     </tr>
                     @endforeach
                     <tr>
                         <td colspan="3" style="font-weight:bold; font-style:italic;">Delivery fees</td>
                         <td style="text-align: right;">
                             {{ $fmt->formatCurrency($order->delivery_charge, "KES") }}
                         </td>
                     </tr>
                 </tbody>

                 <tfoot>
                     <tr>
                         <td style="font-weight:bold; text-align:right; padding-inline: 1rem;" colspan="3">Total</td>
                         <td style="font-weight:bold; text-align: right;">
                             {{ $fmt->formatCurrency(($order->order_total + $order->delivery_charge), "KES")}}
                         </td>
                     </tr>
                 </tfoot>
             </table>
         </div>
         <p>
             Kind regards, <br />
             E-budget Team
         </p>
     </main>
 </body>

 </html>
