-- =====================================================
-- Update Role & Permissions Menu Structure
-- =====================================================

-- Step 1: Clean existing data (disable foreign key checks)
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE admin_role_menu_permission;
TRUNCATE TABLE admin_menu_permission;
SET FOREIGN_KEY_CHECKS = 1;

-- Step 2: Verify menus exist
-- Dashboard (id=1)
-- Role & Permissions (id=2, parent)
-- Admin Roles (id=3, child of 2)
-- Admin Permissions (id=4, child of 2)
-- Menu Permissions (id=5, child of 2)
-- Role Menu Permissions (id=6, child of 2)
-- Admin Menus (id=7, child of 2)
-- Admin (id=8, parent)
-- Admins (id=9, child of 8)

-- Step 3: Verify permissions exist
-- sidebar-menu (id=1)
-- create (id=2)
-- edit (id=3)
-- view (id=4)
-- delete (id=5)

-- =====================================================
-- MENU PERMISSION MAPPING
-- =====================================================

-- Dashboard (only sidebar-menu)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(1, 1, NOW(), NOW()); -- sidebar-menu

-- Role & Permissions ROOT MENU (only sidebar-menu)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(2, 1, NOW(), NOW()); -- sidebar-menu

-- Admin Roles CHILD (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(3, 1, NOW(), NOW()), -- sidebar-menu
(3, 2, NOW(), NOW()), -- create
(3, 3, NOW(), NOW()), -- edit
(3, 4, NOW(), NOW()), -- view
(3, 5, NOW(), NOW()); -- delete

-- Admin Permissions CHILD (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(4, 1, NOW(), NOW()), -- sidebar-menu
(4, 2, NOW(), NOW()), -- create
(4, 3, NOW(), NOW()), -- edit
(4, 4, NOW(), NOW()), -- view
(4, 5, NOW(), NOW()); -- delete

-- Menu Permissions CHILD (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(5, 1, NOW(), NOW()), -- sidebar-menu
(5, 2, NOW(), NOW()), -- create
(5, 3, NOW(), NOW()), -- edit
(5, 4, NOW(), NOW()), -- view
(5, 5, NOW(), NOW()); -- delete

-- Role Menu Permissions CHILD (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(6, 1, NOW(), NOW()), -- sidebar-menu
(6, 2, NOW(), NOW()), -- create
(6, 3, NOW(), NOW()), -- edit
(6, 4, NOW(), NOW()), -- view
(6, 5, NOW(), NOW()); -- delete

-- Admin Menus CHILD (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(7, 1, NOW(), NOW()), -- sidebar-menu
(7, 2, NOW(), NOW()), -- create
(7, 3, NOW(), NOW()), -- edit
(7, 4, NOW(), NOW()), -- view
(7, 5, NOW(), NOW()); -- delete

-- Admin ROOT MENU (only sidebar-menu)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(8, 1, NOW(), NOW()); -- sidebar-menu

-- Admins CHILD (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(9, 1, NOW(), NOW()), -- sidebar-menu
(9, 2, NOW(), NOW()), -- create
(9, 3, NOW(), NOW()), -- edit
(9, 4, NOW(), NOW()), -- view
(9, 5, NOW(), NOW()); -- delete

-- =====================================================
-- ROLE MENU PERMISSIONS (Super Admin = ALL ACCESS)
-- =====================================================

-- Get super_admin role_id
SET @super_admin_id = (SELECT id FROM admin_roles WHERE slug = 'super_admin' LIMIT 1);

-- Assign ALL menu_permissions to Super Admin
INSERT INTO admin_role_menu_permission (role_id, menu_permission_id, allow, created_at, updated_at)
SELECT 
    @super_admin_id,
    id,
    1, -- allow = true
    NOW(),
    NOW()
FROM admin_menu_permission;

-- =====================================================
-- VERIFICATION QUERIES
-- =====================================================

-- Check menu structure
SELECT 
    m.id,
    m.name,
    m.parent_id,
    m.sort_order,
    GROUP_CONCAT(p.slug ORDER BY p.id) as permissions
FROM admin_menus m
LEFT JOIN admin_menu_permission amp ON m.id = amp.menu_id
LEFT JOIN admin_permissions p ON amp.permission_id = p.id
WHERE m.is_active = 1
GROUP BY m.id, m.name, m.parent_id, m.sort_order
ORDER BY m.parent_id, m.sort_order;

-- Check super admin permissions count
SELECT 
    COUNT(*) as total_permissions
FROM admin_role_menu_permission armp
INNER JOIN admin_roles ar ON armp.role_id = ar.id
WHERE ar.slug = 'super_admin' AND armp.allow = 1;

-- Expected counts:
-- Dashboard: 1 permission (sidebar-menu)
-- Role & Permissions ROOT: 1 permission (sidebar-menu)
-- Role & Permissions CHILDREN (5 menus): 5 permissions each = 25 permissions
-- Admin ROOT: 1 permission (sidebar-menu)
-- Admins CHILD: 5 permissions
-- TOTAL: 1 + 1 + 25 + 1 + 5 = 33 permissions

SELECT '✅ Update complete! Super Admin has access to all menu permissions.' as status;

