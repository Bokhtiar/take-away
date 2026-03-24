<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="max-w-5xl mx-auto py-10 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">My Orders</h1>
            <a href="/" class="text-sm font-medium text-blue-600 hover:text-blue-800">Back to Home</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-4 py-3">Order ID</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Payment</th>
                        <th class="text-left px-4 py-3">Total</th>
                        <th class="text-left px-4 py-3">Date</th>
                        <th class="text-left px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-4 py-3 font-medium">#{{ $order->id }}</td>
                            <td class="px-4 py-3 capitalize">{{ $order->order_status }}</td>
                            <td class="px-4 py-3 capitalize">{{ $order->payment_status }}</td>
                            <td class="px-4 py-3">${{ number_format((float) $order->total_amount, 2) }}</td>
                            <td class="px-4 py-3">{{ $order->created_at?->format('d M Y h:i A') }}</td>
                            <td class="px-4 py-3">
                                <a class="text-blue-600 hover:text-blue-800" href="{{ route('orders.show', $order->id) }}">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</body>
</html>

