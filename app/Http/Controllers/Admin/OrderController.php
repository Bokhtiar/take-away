<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderUpdateRequest;
use App\Services\Admin\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService) {}

    public function index(Request $request)
    {
        $orders = $this->orderService->index(
            (int) $request->get('per_page', 10),
            $request->get('search'),
            $request->get('order_status'),
            $request->get('payment_status')
        );

        return view('admin.orders.index', compact('orders'));
    }

    public function show(string $id)
    {
        $order = $this->orderService->find((int) $id);

        return view('admin.orders.show', compact('order'));
    }

    public function update(OrderUpdateRequest $request, string $id)
    {
        $order = $this->orderService->find((int) $id);
        $this->orderService->updateStatus($order, $request->validated());
        $order->refresh();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully.',
                'order_status' => $order->order_status,
                'payment_status' => $order->payment_status,
            ]);
        }

        return redirect()
            ->route('admin.orders.show', $order->id)
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(string $id)
    {
        $order = $this->orderService->find((int) $id);
        $this->orderService->softDelete($order);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order removed successfully.');
    }
}
