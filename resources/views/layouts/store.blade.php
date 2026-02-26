<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mini Store</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    .nav-bar {
        display: flex;
        align-items: center;
        gap: 30px;
        font-size: 16px;
        padding: 10px 0;
    }

    .nav-bar a {
        text-decoration: none;
        color: #4B5563;
        position: relative;
        transition: color 0.3s;
    }

    .nav-bar a:hover {
        color: #3B82F6;
    }



    .cart-count {
        position: absolute;
        top: -8px;
        right: -15px;
        background-color: #ef4444;
        color: white;
        font-size: 12px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 50%;
        line-height: 1;
    }
</style>

<body class="bg-gray-100">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between">

            <a href="{{ route('products.index') }}" class="text-xl font-bold text-gray-800">
                🛒 Mini Store
            </a>
            @php
                $cartItems = session('cart', []);
                $cartCount = collect($cartItems)->sum('quantity');
            @endphp
            <div class="nav-bar">
                <a href="{{ route('products.index') }}">Products</a>

                <a href="{{ route('cart.index') }}" class="cart-link">
                    Cart
                    @if ($cartCount > 0)
                        <span class="cart-count">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    <a href="/dashboard">Admin</a>
                @endauth
            </div>

        </div>
    </nav>

    <!-- Content -->
    <div class="max-w-7xl mx-auto p-6">

        @if (session('success'))
            <div
                style="background-color:#d1fae5; border:1px solid #10b981; color:#065f46; padding:12px; border-radius:8px; margin-bottom:16px;">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                style="background-color:#fee2e2; border:1px solid #ef4444; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:16px;">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')

    </div>

</body>

</html>
