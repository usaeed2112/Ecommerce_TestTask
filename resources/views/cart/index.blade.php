@extends('layouts.store')

@section('content')
    <style>
        .cart-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .cart-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            transition: 0.3s;
            background-color: #fff;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .cart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .cart-card-header h5 {
            margin: 0 0 10px;
            font-size: 1.2rem;
            color: #333;
        }

        .cart-card-body p {
            margin: 5px 0;
            font-size: 0.95rem;
            color: #555;
        }

        .quantity-form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }

        .quantity-form input[type="number"] {
            width: 60px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .quantity-form button {
            padding: 5px 10px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .quantity-form button:hover {
            background-color: #0b5ed7;
        }

        .cart-card-footer {
            text-align: right;
        }

        .btn-remove {
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-remove:hover {
            background-color: #b02a37;
        }

        .cart-summary {
            margin-top: 30px;
            padding: 20px;
            border-top: 2px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .cart-actions a {
            padding: 10px 20px;
            margin-left: 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }

        .empty-cart {
            text-align: center;
            font-size: 1.1rem;
            color: #666;
            margin-top: 50px;
        }

        .checkout-form .form-group {
            margin-bottom: 15px;
        }

        .checkout-form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .checkout-form input,
        .checkout-form textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .checkout-form textarea {
            resize: vertical;
        }

        .cart-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-checkout {
            background-color: #198754;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .btn-checkout:hover {
            background-color: #157347;
        }

        .btn-clear {
            background-color: #ffc107;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-clear:hover {
            background-color: #e0a800;
        }
    </style>
    <div class="container py-5">
        <h2 class="mb-4 text-center">🛒 Your Shopping Cart</h2>

        @if (count($cartItems) > 0)
            <div class="cart-grid">
                @foreach ($cartItems as $item)
                    <div class="cart-card">
                        <div class="cart-card-header">
                            <h5>{{ $item['name'] }}</h5>
                        </div>
                        <div class="cart-card-body">
                            <p>Price: ${{ number_format($item['price'], 2) }}</p>
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="quantity-form">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1">
                                <button type="submit">Update</button>
                            </form>
                            <p>Total: ${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                        <div class="cart-card-footer">
                            <a href="{{ route('cart.remove', $item['id']) }}" class="btn-remove">Remove</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="cart-summary">
                <h3>Total Amount: ${{ number_format($cartTotal, 2) }}</h3>

                <form action="{{ route('checkout') }}" method="POST" class="checkout-form">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" required placeholder="Your full name">
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" required placeholder="Your email address">
                    </div>

                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea name="address" id="address" rows="3" required placeholder="Delivery address"></textarea>
                    </div>

                    <div class="cart-actions">
                        <a href="{{ route('cart.clear') }}" class="btn-clear">Clear Cart</a>
                        <button type="submit" class="btn-checkout">Place Order (Cash on Delivery)</button>
                    </div>
                </form>
            </div>
        @else
            <p class="empty-cart">Your cart is empty. <a href="{{ url('/products') }}">Go shopping!</a></p>
        @endif
    </div>
@endsection
