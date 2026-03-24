<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.base_price' => ['nullable', 'numeric', 'min:0'],
            'items.*.addons' => ['nullable', 'array'],
            'items.*.addons.*.addon_id' => ['required_with:items.*.addons', 'integer', 'exists:addons,id'],
        ];
    }
}

