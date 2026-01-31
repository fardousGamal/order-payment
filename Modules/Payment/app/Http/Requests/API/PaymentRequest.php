<?php

namespace Modules\Payment\App\Http\Requests\API;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class PaymentRequest extends FormRequest
{
    public function rules(): array
    {

        return [
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string',


        ];
    }

}
