<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data (optional - be careful in production)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('admin_role_menu_permission')->truncate();
        DB::table('admin_menu_permission')->truncate();
        DB::table('admin_menus')->truncate();
        DB::table('admin_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ======================
        // 1. CREATE PERMISSIONS
        // ======================
        $permissions = [
            ['name' => 'Access', 'slug' => 'access', 'description' => 'Can access/view menu'],
            ['name' => 'Create', 'slug' => 'create', 'description' => 'Can create new records'],
            ['name' => 'Edit', 'slug' => 'edit', 'description' => 'Can edit records'],
            ['name' => 'View', 'slug' => 'view', 'description' => 'Can view record details'],
            ['name' => 'Delete', 'slug' => 'delete', 'description' => 'Can delete records'],
        ];

        foreach ($permissions as $permission) {
            DB::table('admin_permissions')->insert([
                'name' => $permission['name'],
                'slug' => $permission['slug'],
                'description' => $permission['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Get permission IDs
        $accessId = DB::table('admin_permissions')->where('slug', 'access')->value('id');
        $createId = DB::table('admin_permissions')->where('slug', 'create')->value('id');
        $editId = DB::table('admin_permissions')->where('slug', 'edit')->value('id');
        $viewId = DB::table('admin_permissions')->where('slug', 'view')->value('id');
        $deleteId = DB::table('admin_permissions')->where('slug', 'delete')->value('id');

        // ======================
        // 2. CREATE MENUS
        // ======================

        // Dashboard (Root Menu - Single)
        DB::table('admin_menus')->insert([
            'id' => 1,
            'name' => 'Dashboard',
            'slug' => 'dashboard',
            'icon' => 'ri-dashboard-line',
            'url' => '/admin/dashboard',
            'parent_id' => null,
            'sort_order' => 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Role Permission (Root Menu)
        DB::table('admin_menus')->insert([
            'id' => 2,
            'name' => 'Role & Permissions',
            'slug' => 'role-permissions',
            'icon' => 'ri-shield-user-line',
            'url' => null,
            'parent_id' => null,
            'sort_order' => 2,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Role Permission Children
        DB::table('admin_menus')->insert([
            [
                'id' => 3,
                'name' => 'Admin Roles',
                'slug' => 'admin-roles',
                'icon' => 'ri-shield-check-line',
                'url' => '/admin/admin-roles',
                'parent_id' => 2,
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Admin Permissions',
                'slug' => 'admin-permissions',
                'icon' => 'ri-key-line',
                'url' => '/admin/admin-permissions',
                'parent_id' => 2,
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Menu Permissions',
                'slug' => 'menu-permissions',
                'icon' => 'ri-links-line',
                'url' => '/admin/admin-menu-permissions',
                'parent_id' => 2,
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'Role Menu Permissions',
                'slug' => 'role-menu-permissions',
                'icon' => 'ri-shield-star-line',
                'url' => '/admin/admin-role-menu-permissions',
                'parent_id' => 2,
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => 'Admin Menus',
                'slug' => 'admin-menus',
                'icon' => 'ri-menu-line',
                'url' => '/admin/admin-menus',
                'parent_id' => 2,
                'sort_order' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Admin (Root Menu)
        DB::table('admin_menus')->insert([
            'id' => 8,
            'name' => 'Admin',
            'slug' => 'admin',
            'icon' => 'ri-admin-line',
            'url' => null,
            'parent_id' => null,
            'sort_order' => 3,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Admin Child Menus
        DB::table('admin_menus')->insert([
            [
                'id' => 9,
                'name' => 'Admins',
                'slug' => 'admins',
                'icon' => 'ri-team-line',
                'url' => '/admin/admins',
                'parent_id' => 8,
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'name' => 'Categories',
                'slug' => 'categories',
                'icon' => 'ri-price-tag-3-line',
                'url' => '/admin/categories',
                'parent_id' => 8,
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'name' => 'Products',
                'slug' => 'products',
                'icon' => 'ri-shopping-bag-3-line',
                'url' => '/admin/products',
                'parent_id' => 8,
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'name' => 'Ingredients',
                'slug' => 'ingredients',
                'icon' => 'ri-restaurant-line',
                'url' => '/admin/ingredients',
                'parent_id' => 11,
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 13,
                'name' => 'Product Ingredients',
                'slug' => 'product-ingredients',
                'icon' => 'ri-list-check-3',
                'url' => '/admin/product-ingredients',
                'parent_id' => 11,
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // ======================
        // 3. CREATE MENU-PERMISSION MAPPINGS
        // ======================

        $menuPermissions = [
            // Dashboard
            ['menu_id' => 1, 'permission_id' => $accessId],

            // Role & Permissions (Parent)
            ['menu_id' => 2, 'permission_id' => $accessId],

            // Admin Roles
            ['menu_id' => 3, 'permission_id' => $accessId],
            ['menu_id' => 3, 'permission_id' => $createId],
            ['menu_id' => 3, 'permission_id' => $editId],
            ['menu_id' => 3, 'permission_id' => $viewId],
            ['menu_id' => 3, 'permission_id' => $deleteId],

            // Admin Permissions
            ['menu_id' => 4, 'permission_id' => $accessId],
            ['menu_id' => 4, 'permission_id' => $createId],
            ['menu_id' => 4, 'permission_id' => $editId],
            ['menu_id' => 4, 'permission_id' => $viewId],
            ['menu_id' => 4, 'permission_id' => $deleteId],

            // Menu Permissions
            ['menu_id' => 5, 'permission_id' => $accessId],
            ['menu_id' => 5, 'permission_id' => $createId],
            ['menu_id' => 5, 'permission_id' => $editId],
            ['menu_id' => 5, 'permission_id' => $viewId],
            ['menu_id' => 5, 'permission_id' => $deleteId],

            // Role Menu Permissions
            ['menu_id' => 6, 'permission_id' => $accessId],
            ['menu_id' => 6, 'permission_id' => $createId],
            ['menu_id' => 6, 'permission_id' => $editId],
            ['menu_id' => 6, 'permission_id' => $viewId],
            ['menu_id' => 6, 'permission_id' => $deleteId],

            // Admin Menus
            ['menu_id' => 7, 'permission_id' => $accessId],
            ['menu_id' => 7, 'permission_id' => $createId],
            ['menu_id' => 7, 'permission_id' => $editId],
            ['menu_id' => 7, 'permission_id' => $viewId],
            ['menu_id' => 7, 'permission_id' => $deleteId],

            // Admin (Parent)
            ['menu_id' => 8, 'permission_id' => $accessId],

            // Admins (Child with ALL actions)
            ['menu_id' => 9, 'permission_id' => $accessId],  // Access (view page/menu)
            ['menu_id' => 9, 'permission_id' => $createId],  // Create (create button)
            ['menu_id' => 9, 'permission_id' => $editId],    // Edit (edit icon)
            ['menu_id' => 9, 'permission_id' => $viewId],    // View (view icon)
            ['menu_id' => 9, 'permission_id' => $deleteId],  // Delete (delete icon)

            // Categories (Child with ALL actions)
            ['menu_id' => 10, 'permission_id' => $accessId],
            ['menu_id' => 10, 'permission_id' => $createId],
            ['menu_id' => 10, 'permission_id' => $editId],
            ['menu_id' => 10, 'permission_id' => $viewId],
            ['menu_id' => 10, 'permission_id' => $deleteId],

            // Products (Child with ALL actions)
            ['menu_id' => 11, 'permission_id' => $accessId],
            ['menu_id' => 11, 'permission_id' => $createId],
            ['menu_id' => 11, 'permission_id' => $editId],
            ['menu_id' => 11, 'permission_id' => $viewId],
            ['menu_id' => 11, 'permission_id' => $deleteId],

            // Ingredients (Child with ALL actions)
            ['menu_id' => 12, 'permission_id' => $accessId],
            ['menu_id' => 12, 'permission_id' => $createId],
            ['menu_id' => 12, 'permission_id' => $editId],
            ['menu_id' => 12, 'permission_id' => $viewId],
            ['menu_id' => 12, 'permission_id' => $deleteId],

            // Product Ingredients (One page)
            ['menu_id' => 13, 'permission_id' => $accessId],
            ['menu_id' => 13, 'permission_id' => $createId],
            ['menu_id' => 13, 'permission_id' => $editId],
            ['menu_id' => 13, 'permission_id' => $viewId],
            ['menu_id' => 13, 'permission_id' => $deleteId],
        ];

        foreach ($menuPermissions as $mp) {
            DB::table('admin_menu_permission')->insert([
                'menu_id' => $mp['menu_id'],
                'permission_id' => $mp['permission_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ======================
        // 4. ASSIGN TO SUPER ADMIN ROLE (Full Access)
        // ======================

        // Get Super Admin role
        $superAdminRoleId = DB::table('admin_roles')->where('slug', 'super_admin')->value('id');

        if ($superAdminRoleId) {
            // Get all menu_permission IDs
            $allMenuPermissions = DB::table('admin_menu_permission')->pluck('id');

            // Assign all to Super Admin with allow = true
            foreach ($allMenuPermissions as $mpId) {
                DB::table('admin_role_menu_permission')->insert([
                    'role_id' => $superAdminRoleId,
                    'menu_permission_id' => $mpId,
                    'allow' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $this->command->info('✅ Super Admin role assigned all permissions!');
        } else {
            $this->command->warn('⚠️  Super Admin role not found. Please run AdminRoleSeeder first!');
        }

        $this->command->info('🎉 Menu and Permission seeding completed successfully!');
    }
}

