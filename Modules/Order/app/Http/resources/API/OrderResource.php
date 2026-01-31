<?php

namespace Modules\Order\app\Http\resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'=> $this->id,
            'total_price' => $this->total_amount,
            'status' => $this->status,
            'items' => OrderItemResource::collection($this->items),
        ];
    }
}
