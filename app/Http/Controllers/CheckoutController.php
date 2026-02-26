<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function checkout(Request $request)
    {
        $customer = $request->only('name', 'email', 'address');

        $result = $this->checkoutService->checkout($customer);

        if ($result['success']) {
            return redirect()->route('cart.index')->with('success', 'Order placed successfully! Order ID: ' . $result['order']->id);
        } else {
            return redirect()->route('cart.index')->with('error', $result['message']);
        }
    }
}
