<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\RefundService;

class OrderController extends Controller
{
    protected $refundService;

    public function __construct(RefundService $refundService)
    {
        $this->refundService = $refundService;
    }
    /**
     * Display all orders
     */
    public function index()
    {
        $orders = Order::with('items.product')
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Refund order
     */
    public function refund(Order $order)
    {
        $result = $this->refundService->refund($order);

        if ($result['success']) {
            return back()->with('success', 'Order refunded successfully.');
        }

        return back()->with('error', $result['message']);
    }

    /**
     * Complete order
     */

    public function complete(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be completed.');
        }

        $order->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Order marked as completed.');
    }
}
