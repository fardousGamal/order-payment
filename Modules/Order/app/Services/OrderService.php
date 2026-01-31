<?php

namespace Modules\Order\App\Services;

use App\Enums\OrderStatus;
use Illuminate\Support\Facades\DB;
use Modules\Order\App\Models\Order;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class OrderService
{
    public function create(array $items, int $userId): Order
    {
        $total = collect($items)->sum(
            fn ($item) => $item['price'] * $item['quantity']
        );

        $order = Order::create([
            'user_id'      => $userId,
            'status'       => OrderStatus::PENDING,
            'total_amount' => $total,
        ]);
        $order->items()->createMany($items);
        return $order->load('items');

    }
    public function update(int $id, array $data): Order
    {
        $order = Order::findOrFail($id);

        if ( in_array($order->status , [OrderStatus::CANCELLED->value , OrderStatus::COMPLETED->value] )) {
            throw new ConflictHttpException('Cancelled and completed order cannot be updated');

        }

        return DB::transaction(function () use ($order, $data) {
            $order->items()->delete();
            $total = collect($data['items'])->sum(
                fn ($item) => $item['price'] * $item['quantity']
            );
            $order->items()->createMany($data['items']);
            $order->total_amount = $total;
            $order->save();
            return $order->load('items');
        });
    }

    public function delete(int $id): void
    {
        $order = Order::findOrFail($id);

        if ($order->status == OrderStatus::COMPLETED) {
            throw new ConflictHttpException('Order has payments cannot be deleted');
        }

        $order->delete();
    }


}
