<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Show cart page
     */
    public function index()
    {
        $cartItems = $this->cartService->getCartItems();
        $cartTotal = $this->cartService->getTotal();

        return view('cart.index', compact('cartItems', 'cartTotal'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $quantity = $request->input('quantity', 1);

        if ($quantity > $product->stock_quantity) {
            return redirect()->back()->with('error', 'Quantity exceeds stock!');
        }

        $this->cartService->addToCart($product, $quantity);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Remove item from cart
     */
    public function remove($productId)
    {
        $this->cartService->removeFromCart($productId);
        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    /**
     * Update item quantity
     */
    public function update(Request $request, $productId)
    {
        $quantity = $request->input('quantity', 1);
        $product = Product::findOrFail($productId);

        if ($quantity > $product->stock_quantity) {
            return redirect()->back()->with('error', 'Quantity exceeds stock!');
        }

        $this->cartService->updateCart($productId, $quantity);

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $this->cartService->clear();
        return redirect()->back()->with('success', 'Cart cleared!');
    }
}
