<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $roleId = $this->route('admin_role'); // Get role ID from route (null for create)
        
        return [
            'name' => 'required|string|max:255|unique:admin_roles,name,' . ($roleId ?: 'NULL'),
            'slug' => 'nullable|string|max:255|unique:admin_roles,slug,' . ($roleId ?: 'NULL'),
            'description' => 'nullable|string',
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
            'name.required' => 'Role name is required.',
            'name.max' => 'Role name must not exceed 255 characters.',
            'name.unique' => 'This role name already exists. Please use a different name.',
            
            'slug.unique' => 'This slug is already taken. Please use a different slug.',
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
            'name' => 'role name',
            'slug' => 'slug',
            'description' => 'description',
        ];
    }
}

