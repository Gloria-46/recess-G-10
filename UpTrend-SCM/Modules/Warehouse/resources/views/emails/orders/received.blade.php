@component('mail::message')
# Order Received

Dear {{ $order->retailer_name }},

Thank you for your order! We have received your order (Order #{{ $order->order_number }}).

**Order Details:**
- **Order Number:** {{ $order->order_number }}
- **Order Date:** {{ $order->order_date->format('Y-m-d H:i') }}
- **Shipping Method:** {{ $order->shipping_method }}

**Items Ordered:**
@component('mail::table')
| Image | Product | Color | Size | Quantity | Price (UGX) |
|-------|---------|-------|------|----------|-------------|
@foreach($order->orderItems as $item)
| @if($item->product && $item->product->image)<img src="{{ asset('storage/' . $item->product->image) }}" width="40" height="40" style="object-fit:cover; border-radius:0.3rem;">@else - @endif | {{ $item->product_name }} | {{ $item->product_color ?? '-' }} | {{ $item->product_size ?? '-' }} | {{ $item->quantity }} | UGX {{ number_format($item->unit_price, 0) }} |
@endforeach
@endcomponent

We will process your order and notify you once it is shipped.

Thank you for choosing us!

Best regards,
Warehouse Team
@endcomponent
