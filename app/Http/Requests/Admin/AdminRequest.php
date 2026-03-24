<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $adminId = $this->route('admin'); // Get admin ID from route (null for create)
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . ($adminId ?: 'NULL'),
            'phone' => 'required|string|max:20|unique:admins,phone,' . ($adminId ?: 'NULL'),
            'password' => $isUpdate ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:admin_roles,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
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
            'name.required' => 'Admin name is required.',
            'name.max' => 'Admin name must not exceed 255 characters.',
            
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered. Please use a different email.',
            
            'phone.required' => 'Phone number is required.',
            'phone.unique' => 'This phone number is already registered. Please use a different phone number.',
            
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            
            'role_id.required' => 'Please select a role.',
            'role_id.exists' => 'Selected role does not exist.',
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
            'name' => 'admin name',
            'email' => 'email address',
            'phone' => 'phone number',
            'password' => 'password',
            'role_id' => 'role',
        ];
    }
}

