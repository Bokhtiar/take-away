<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $menuId = $this->route('admin_menu'); // Get menu ID from route (null for create)
        
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:admin_menus,slug,' . ($menuId ?: 'NULL'),
            'icon' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:admin_menus,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Menu name is required.',
            'name.max' => 'Menu name must not exceed 255 characters.',
            
            'slug.required' => 'Menu slug is required.',
            'slug.unique' => 'This slug is already taken. Please use a different slug.',
            
            'parent_id.exists' => 'Selected parent menu does not exist.',
            
            'sort_order.integer' => 'Sort order must be a number.',
            'sort_order.min' => 'Sort order must be at least 0.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'menu name',
            'slug' => 'slug',
            'icon' => 'icon',
            'url' => 'URL',
            'parent_id' => 'parent menu',
            'sort_order' => 'sort order',
            'is_active' => 'status',
        ];
    }

    /**
     * Prepare data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set default values
        $this->merge([
            'is_active' => $this->has('is_active') ? (bool) $this->is_active : true,
            'sort_order' => $this->sort_order ?? 0,
        ]);
    }
}

