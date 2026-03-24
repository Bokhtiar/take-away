<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
        $permissionId = $this->route('admin_permission'); // Get permission ID from route (null for create)
        
        return [
            'name' => 'required|string|max:255|unique:admin_permissions,name,' . ($permissionId ?: 'NULL'),
            'slug' => 'nullable|string|max:255|unique:admin_permissions,slug,' . ($permissionId ?: 'NULL'),
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
            'name.required' => 'Permission name is required.',
            'name.max' => 'Permission name must not exceed 255 characters.',
            'name.unique' => 'This permission name already exists. Please use a different name.',
            
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
            'name' => 'permission name',
            'slug' => 'slug',
            'description' => 'description',
        ];
    }
}

