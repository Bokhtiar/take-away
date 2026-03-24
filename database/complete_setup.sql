-- =====================================================
-- Complete Menu & Permission Setup
-- =====================================================

SET FOREIGN_KEY_CHECKS = 0;

-- Step 1: Clean existing data
TRUNCATE TABLE admin_role_menu_permission;
TRUNCATE TABLE admin_menu_permission;
TRUNCATE TABLE admin_menus;
TRUNCATE TABLE admin_permissions;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- CREATE MENUS
-- =====================================================

INSERT INTO admin_menus (id, name, slug, icon, url, parent_id, sort_order, is_active, created_at, updated_at) VALUES
-- Dashboard (standalone)
(1, 'Dashboard', 'dashboard', 'ri-dashboard-line', '/admin/dashboard', NULL, 1, 1, NOW(), NOW()),

-- Role & Permissions (parent)
(2, 'Role & Permissions', 'role-permissions', 'ri-shield-user-line', NULL, NULL, 2, 1, NOW(), NOW()),
(3, 'Admin Roles', 'admin-roles', 'ri-user-settings-line', '/admin/admin-roles', 2, 1, 1, NOW(), NOW()),
(4, 'Admin Permissions', 'admin-permissions', 'ri-lock-password-line', '/admin/admin-permissions', 2, 2, 1, NOW(), NOW()),
(5, 'Menu Permissions', 'menu-permissions', 'ri-menu-add-line', '/admin/admin-menu-permissions', 2, 3, 1, NOW(), NOW()),
(6, 'Role Menu Permissions', 'role-menu-permissions', 'ri-shield-check-line', '/admin/admin-role-menu-permissions', 2, 4, 1, NOW(), NOW()),
(7, 'Admin Menus', 'admin-menus', 'ri-menu-line', '/admin/admin-menus', 2, 5, 1, NOW(), NOW()),

-- Admin (parent)
(8, 'Admin', 'admin', 'ri-admin-line', NULL, NULL, 3, 1, NOW(), NOW()),
(9, 'Admins', 'admins', 'ri-user-line', '/admin/admins', 8, 1, 1, NOW(), NOW());

-- =====================================================
-- CREATE PERMISSIONS
-- =====================================================

INSERT INTO admin_permissions (id, name, slug, description, created_at, updated_at) VALUES
(1, 'Sidebar Menu', 'sidebar-menu', 'Show menu in sidebar', NOW(), NOW()),
(2, 'Create', 'create', 'Create new records', NOW(), NOW()),
(3, 'Edit', 'edit', 'Edit existing records', NOW(), NOW()),
(4, 'View', 'view', 'View records', NOW(), NOW()),
(5, 'Delete', 'delete', 'Delete records', NOW(), NOW());

-- =====================================================
-- MAP MENU-PERMISSIONS
-- =====================================================

-- Dashboard (only sidebar-menu)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(1, 1, NOW(), NOW());

-- Role & Permissions ROOT (only sidebar-menu)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(2, 1, NOW(), NOW());

-- Admin Roles CHILD (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(3, 1, NOW(), NOW()),
(3, 2, NOW(), NOW()),
(3, 3, NOW(), NOW()),
(3, 4, NOW(), NOW()),
(3, 5, NOW(), NOW());

-- Admin Permissions CHILD (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(4, 1, NOW(), NOW()),
(4, 2, NOW(), NOW()),
(4, 3, NOW(), NOW()),
(4, 4, NOW(), NOW()),
(4, 5, NOW(), NOW());

-- Menu Permissions CHILD (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(5, 1, NOW(), NOW()),
(5, 2, NOW(), NOW()),
(5, 3, NOW(), NOW()),
(5, 4, NOW(), NOW()),
(5, 5, NOW(), NOW());

-- Role Menu Permissions CHILD (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(6, 1, NOW(), NOW()),
(6, 2, NOW(), NOW()),
(6, 3, NOW(), NOW()),
(6, 4, NOW(), NOW()),
(6, 5, NOW(), NOW());

-- Admin Menus CHILD (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(7, 1, NOW(), NOW()),
(7, 2, NOW(), NOW()),
(7, 3, NOW(), NOW()),
(7, 4, NOW(), NOW()),
(7, 5, NOW(), NOW());

-- Admin ROOT (only sidebar-menu)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(8, 1, NOW(), NOW());

-- Admins CHILD (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(9, 1, NOW(), NOW()),
(9, 2, NOW(), NOW()),
(9, 3, NOW(), NOW()),
(9, 4, NOW(), NOW()),
(9, 5, NOW(), NOW());

-- =====================================================
-- ASSIGN TO SUPER ADMIN
-- =====================================================

SET @super_admin_id = (SELECT id FROM admin_roles WHERE slug = 'super_admin' LIMIT 1);

INSERT INTO admin_role_menu_permission (role_id, menu_permission_id, allow, created_at, updated_at)
SELECT 
    @super_admin_id,
    id,
    1,
    NOW(),
    NOW()
FROM admin_menu_permission;

-- =====================================================
-- VERIFICATION
-- =====================================================

SELECT 'Menu Structure:' as '';
SELECT 
    m.id,
    m.name,
    m.parent_id,
    m.sort_order,
    GROUP_CONCAT(p.slug ORDER BY p.id SEPARATOR ', ') as permissions
FROM admin_menus m
LEFT JOIN admin_menu_permission amp ON m.id = amp.menu_id
LEFT JOIN admin_permissions p ON amp.permission_id = p.id
WHERE m.is_active = 1
GROUP BY m.id, m.name, m.parent_id, m.sort_order
ORDER BY m.parent_id, m.sort_order;

SELECT '' as '';
SELECT 'Super Admin Total Permissions:' as '';
SELECT COUNT(*) as total_permissions
FROM admin_role_menu_permission armp
WHERE armp.role_id = @super_admin_id AND armp.allow = 1;

SELECT '' as '';
SELECT '✅ Complete setup done! Super Admin has full access.' as status;

