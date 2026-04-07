<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_status' => ['required', 'string', Rule::in(['pending', 'confirmed', 'preparing', 'completed', 'cancelled'])],
            'payment_status' => ['required', 'string', Rule::in(['unpaid', 'paid', 'refunded'])],
        ];
    }
}
