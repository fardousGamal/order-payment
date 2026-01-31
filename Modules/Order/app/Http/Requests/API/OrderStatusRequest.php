<?php

namespace Modules\Order\App\Http\Requests\API;
use App\Enums\OrderStatus;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class OrderStatusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(OrderStatus::class)],
        ];
    }
}
