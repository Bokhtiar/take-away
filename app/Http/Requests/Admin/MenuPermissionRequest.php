<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuPermissionRequest extends FormRequest
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
        $menuPermissionId = $this->route('admin_menu_permission'); // Get menu permission ID from route (null for create)
        
        return [
            'menu_id' => 'required|exists:admin_menus,id',
            'permission_id' => 'required|exists:admin_permissions,id',
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
            'menu_id.required' => 'Menu is required.',
            'menu_id.exists' => 'Selected menu does not exist.',
            
            'permission_id.required' => 'Permission is required.',
            'permission_id.exists' => 'Selected permission does not exist.',
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
            'menu_id' => 'menu',
            'permission_id' => 'permission',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $menuId = $this->input('menu_id');
            $permissionId = $this->input('permission_id');
            $menuPermissionId = $this->route('admin_menu_permission');

            if ($menuId && $permissionId) {
                $exists = \App\Models\AdminMenuPermission::where('menu_id', $menuId)
                    ->where('permission_id', $permissionId)
                    ->when($menuPermissionId, function ($query) use ($menuPermissionId) {
                        return $query->where('id', '!=', $menuPermissionId);
                    })
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('permission_id', 'This menu-permission combination already exists.');
                }
            }
        });
    }
}

