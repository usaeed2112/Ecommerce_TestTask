<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class RefundService
{
    public function refund(Order $order)
    {
        if ($order->status === 'refunded') {
            return [
                'success' => false,
                'message' => 'Order already refunded'
            ];
        }

        DB::beginTransaction();

        try {

            foreach ($order->items as $item) {

                // Restore stock
                $item->product->increment(
                    'stock_quantity',
                    $item->quantity
                );
            }

            // Update order status
            $order->update([
                'status' => 'refunded'
            ]);

            DB::commit();

            return ['success' => true];

        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
