<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Orders Management
        </h2>
    </x-slot>
    <style>
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .orders-table th,
        .orders-table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .orders-table th {
            background: #f3f4f6;
        }

        .status {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
        }

        .status.completed {
            background: #16a34a;
        }

        .status.pending {
            background: #f59e0b;
        }

        .status.refunded {
            background: #dc2626;
        }

        .btn-refund {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 7px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 6px;
            transition: 0.3s;
        }

        .btn-refund:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        .btn-complete {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 7px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-complete:hover {
            background-color: #27ae60;
            transform: scale(1.05);
        }

        .alert-success {
            background: #d1fae5;
            padding: 10px;
            margin-bottom: 15px;
        }

        .alert-error {
            background: #fee2e2;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>

    <div class="p-6">

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <table class="orders-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Products</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>

                        <td>
                            {{ $order->customer_name }} <br>
                            <small>{{ $order->customer_email }}</small>
                        </td>

                        <td>${{ number_format($order->total_amount, 2) }}</td>

                        <td>
                            <span class="status {{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>

                        <td>
                            @foreach ($order->items as $item)
                                {{ $item->product->name }}
                                (x{{ $item->quantity }})
                                <br>
                            @endforeach
                        </td>

                        {{-- <td>
                            @if ($order->status !== 'refunded')
                                <form method="POST" action="{{ route('admin.orders.refund', $order->id) }}">
                                    @csrf
                                    <button class="btn-refund">
                                        Refund
                                    </button>
                                </form>
                            @else
                                ✅ Refunded
                            @endif
                        </td> --}}
                        <td>

                            {{-- COMPLETE BUTTON --}}
                            @if ($order->status === 'pending')
                                <form method="POST" action="{{ route('admin.orders.complete', $order->id) }}"
                                    style="display:inline;">
                                    @csrf
                                    <button class="btn-complete">
                                        Complete
                                    </button>
                                </form>
                            @endif


                            {{-- REFUND BUTTON --}}
                            @if ($order->status === 'pending' )
                                <form method="POST" action="{{ route('admin.orders.refund', $order->id) }}"
                                    style="display:inline;">
                                    @csrf
                                    <button class="btn-refund">
                                        Refund
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>
