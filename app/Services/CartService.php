<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    protected $cart;

    public function __construct()
    {
        $this->cart = session()->get('cart', []);
    }

    /**
     * Get all cart items
     */
    public function getCartItems()
    {
        return $this->cart;
    }

    /**
     * Add product to cart
     */
    public function addToCart(Product $product, int $quantity = 1)
    {
        $productId = $product->id;

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] += $quantity;
        } else {
            $this->cart[$productId] = [
                'id' => $productId,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
        }

        $this->save();
    }

    /**
     * Remove product from cart
     */
    public function removeFromCart($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            $this->save();
        }
    }

    /**
     * Update cart quantity
     */
    public function updateCart($productId, $quantity)
    {
        if (isset($this->cart[$productId])) {
            if ($quantity <= 0) {
                unset($this->cart[$productId]);
            } else {
                $this->cart[$productId]['quantity'] = $quantity;
            }
            $this->save();
        }
    }

    /**
     * Get cart total
     */
    public function getTotal()
    {
        return collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    /**
     * Save cart to session
     */
    protected function save()
    {
        session()->put('cart', $this->cart);
        session()->save();
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        $this->cart = [];
        $this->save();
    }
}
