<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    public function store(OrderStoreRequest $request): JsonResponse
    {
        $order = $this->orderService->createForUser((int) auth()->id(), $request->validated());

        return response()->json([
            'message' => 'Order placed successfully.',
            'order_id' => $order->id,
            'total_amount' => (float) $order->total_amount,
        ]);
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->userOrders((int) auth()->id(), (int) $request->get('per_page', 10));

        return view('orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = $this->orderService->userOrderDetails((int) auth()->id(), $id);

        return view('orders.show', compact('order'));
    }
}

