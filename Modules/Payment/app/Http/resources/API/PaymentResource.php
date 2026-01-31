<?php

namespace Modules\Payment\app\Http\resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'total_price' => $this->amount,
            'status' => $this->status,
            'payment_method'=> $this->payment_method,
        ];
    }
}
