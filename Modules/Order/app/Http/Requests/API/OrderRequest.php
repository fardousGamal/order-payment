<?php

namespace Modules\Order\App\Http\Requests\API;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class OrderRequest extends FormRequest
{
    public function rules(): array
    {

        return [
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',

        ];
    }

}
