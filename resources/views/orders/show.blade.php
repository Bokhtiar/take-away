<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="max-w-5xl mx-auto py-10 px-4 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Order #{{ $order->id }}</h1>
            <a href="{{ route('orders.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">Back to Orders</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <p class="text-xs text-gray-500 uppercase">Customer</p>
                <p class="font-semibold">{{ $order->customer_name }}</p>
                <p class="text-sm text-gray-600">{{ $order->customer_phone }}</p>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <p class="text-xs text-gray-500 uppercase">Order Status</p>
                <p class="font-semibold capitalize">{{ $order->order_status }}</p>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <p class="text-xs text-gray-500 uppercase">Payment</p>
                <p class="font-semibold capitalize">{{ $order->payment_status }}</p>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <p class="text-xs text-gray-500 uppercase">Total</p>
                <p class="font-semibold">${{ number_format((float) $order->total_amount, 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="font-semibold">Items</h2>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold">{{ $item->product?->name ?? 'Product' }}</h3>
                                <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} | Unit Price: ${{ number_format((float) $item->price, 2) }}</p>
                            </div>
                            <div class="font-medium">
                                ${{ number_format(((float) $item->price) * $item->quantity, 2) }}
                            </div>
                        </div>
                        @if($item->addons->isNotEmpty())
                            <div class="mt-2 text-sm text-gray-600">
                                Addons:
                                {{ $item->addons->map(fn($addon) => ($addon->addon?->name ?? 'Addon') . ' ($' . number_format((float) $addon->price, 2) . ')')->implode(', ') }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>

