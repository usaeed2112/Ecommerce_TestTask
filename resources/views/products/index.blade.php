@extends('layouts.store')

@section('content')

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f7f8fa;
        color: #333;
    }

    h1 {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 40px;
        color: #1f2937;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .product-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s, box-shadow 0.3s;
        text-align: center;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.12);
    }

    .product-image {
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e5e7eb;
    }

    .product-image img {
        width: 80px;
        height: 80px;
        object-fit: contain;
    }

    .product-details {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-name {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #111827;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 5px;
    }

    .product-stock {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 15px;
    }

    .add-to-cart-btn {
        display: block;
        width: 100%;
        background-color: #2563eb;
        color: #fff;
        font-weight: 600;
        text-align: center;
        padding: 10px 0;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background 0.3s, transform 0.3s;
        text-decoration: none;
    }

    .add-to-cart-btn:hover {
        background-color: #1d4ed8;
        transform: translateY(-2px);
    }

    input[type="number"] {
        width: 60px;
        padding: 6px 8px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        margin-right: 10px;
    }

    @media (max-width: 1024px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .products-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<h1>Available Products</h1>

<div class="products-grid">

    @foreach($products as $product)
    <div class="product-card">

        <!-- Product Image (Fixed Icon) -->
        <div class="product-image">
            <img src="https://cdn-icons-png.flaticon.com/512/1170/1170576.png" alt="Product Icon">
        </div>

        <!-- Product Details -->
        <div class="product-details">
            <div>
                <h2 class="product-name">{{ $product->name }}</h2>
                <p class="product-price">${{ number_format($product->price, 2) }}</p>
                <p class="product-stock">Stock: {{ $product->stock_quantity }}</p>
            </div>

            <!-- Add To Cart Form -->
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex items-center justify-center mt-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}">
                <button type="submit" class="add-to-cart-btn">Add to Cart</button>
            </form>
        </div>
    </div>
    @endforeach

</div>

@endsection
