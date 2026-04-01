<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ChefRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $chefId = (int) ($this->route('chef') ?? $this->route('id') ?? 0);

        $passwordRules = $this->isMethod('post')
            ? ['required', 'string', 'min:6']
            : ['nullable', 'string', 'min:6'];

        return [
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', "unique:chefs,phone,{$chefId}"],
            'image_url' => ['nullable', 'string', 'max:255'],
            'password' => $passwordRules,
        ];
    }
}

