<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleMenuPermissionRequest extends FormRequest
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
        $roleMenuPermissionId = $this->route('admin_role_menu_permission'); // Get role menu permission ID from route (null for create)
        
        return [
            'role_id' => 'required|exists:admin_roles,id',
            'menu_permission_id' => 'required|exists:admin_menu_permission,id',
            'allow' => 'nullable|boolean',
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
            'role_id.required' => 'Role is required.',
            'role_id.exists' => 'Selected role does not exist.',
            
            'menu_permission_id.required' => 'Menu permission is required.',
            'menu_permission_id.exists' => 'Selected menu permission does not exist.',
            
            'allow.boolean' => 'Allow must be a boolean value.',
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
            'role_id' => 'role',
            'menu_permission_id' => 'menu permission',
            'allow' => 'allow',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert 'allow' to boolean if it's a string
        if ($this->has('allow')) {
            $this->merge([
                'allow' => filter_var($this->allow, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true,
            ]);
        } else {
            $this->merge(['allow' => true]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $roleId = $this->input('role_id');
            $menuPermissionId = $this->input('menu_permission_id');
            $roleMenuPermissionId = $this->route('admin_role_menu_permission');

            if ($roleId && $menuPermissionId) {
                $exists = \App\Models\AdminRoleMenuPermission::where('role_id', $roleId)
                    ->where('menu_permission_id', $menuPermissionId)
                    ->when($roleMenuPermissionId, function ($query) use ($roleMenuPermissionId) {
                        return $query->where('id', '!=', $roleMenuPermissionId);
                    })
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('menu_permission_id', 'This role-menu-permission combination already exists.');
                }
            }
        });
    }
}

