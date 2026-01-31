<?php

namespace Modules\Order\app\Http\resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'product_name' => $this->product_name,
            'quantity' => $this->quantity,
            'price' => $this->price,

        ];
    }
}
