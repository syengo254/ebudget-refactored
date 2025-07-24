 @php
 $fmt = new \NumberFormatter( 'en_KE', \NumberFormatter::CURRENCY );
 @endphp
 <x-email>
     <x-slot:title>Order for {{ $order->user->name }} Created</x-slot:title>
     Hello {{ $order->user->name }},
     <p>
         Your order has been received and shall be delivered on <strong>{{ $order->expected_delivery_date }}</strong> (latest on: <b>{{ $order->latest_delivery_date }}</b>).
     </p>
     <p>
         <strong>Order Number: </strong>{{ $order->order_no }}
     </p>
     <p>
         <strong>Order Status: </strong><span style="text-transform:capitalize;">{{ $order->status }}</span>
     </p>
     <div>
         <h4>Order Summary</h4>
         <p><i>Total items ({{ $order->all_items_count }})</i></p>
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
                     <td style="padding-inline: 1rem;" colspan="3">Total</td>
                     <td>
                         {{ $fmt->formatCurrency(($order->order_total + $order->delivery_charge), "KES")}}
                     </td>
                 </tr>
             </tfoot>
         </table>
     </div>
     <p>Thank you for shopping with us!</p>
     <p>
         Kind regards, <br />
         E-budget Team
     </p>
 </x-email>
