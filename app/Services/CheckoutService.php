<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutService
{
    protected $cart;

    public function __construct()
    {
        $this->cart = Session::get('cart', []);
    }

    /**
     * Perform checkout
     */
    public function checkout(array $customer = [])
    {
        if (empty($this->cart)) {
            return ['success' => false, 'message' => 'Cart is empty!'];
        }

        // Validate stock
        foreach ($this->cart as $item) {
            $product = Product::find($item['id']);
            if (!$product) {
                return ['success' => false, 'message' => "{$item['name']} does not exist!"];
            }
            if ($item['quantity'] > $product->stock_quantity) {
                return ['success' => false, 'message' => "Not enough stock for {$product->name}!"];
            }
        }

        DB::beginTransaction();

        try {
            $totalAmount = collect($this->cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });
            $order = Order::create([
                'customer_name' => $customer['name'] ?? 'Guest',
                'customer_email' => $customer['email'] ?? null,
                'customer_address' => $customer['address'] ?? null,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            foreach ($this->cart as $item) {
                $product = Product::find($item['id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price
                ]);
                $product->decrement('stock_quantity', $item['quantity']);
            }
            Session::forget('cart');

            DB::commit();

            return ['success' => true, 'order' => $order];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
