-- ========================================
-- Menu & Permissions Data Seeder
-- ========================================
-- Run this SQL in your MySQL database
-- ========================================

-- Clear existing data (OPTIONAL - be careful!)
TRUNCATE TABLE admin_role_menu_permission;
TRUNCATE TABLE admin_menu_permission;
TRUNCATE TABLE admin_menus;
TRUNCATE TABLE admin_permissions;

-- ========================================
-- 1. INSERT PERMISSIONS
-- ========================================
INSERT INTO admin_permissions (id, name, slug, description, created_at, updated_at) VALUES
(1, 'Access', 'access', 'Can access/view menu', NOW(), NOW()),
(2, 'Create', 'create', 'Can create new records', NOW(), NOW()),
(3, 'Edit', 'edit', 'Can edit records', NOW(), NOW()),
(4, 'View', 'view', 'Can view record details', NOW(), NOW()),
(5, 'Delete', 'delete', 'Can delete records', NOW(), NOW());

-- ========================================
-- 2. INSERT MENUS
-- ========================================

-- Dashboard (Single Root Menu)
INSERT INTO admin_menus (id, name, slug, icon, url, parent_id, sort_order, is_active, created_at, updated_at) VALUES
(1, 'Dashboard', 'dashboard', 'ri-dashboard-line', '/admin/dashboard', NULL, 1, 1, NOW(), NOW());

-- Role & Permissions (Root Menu)
INSERT INTO admin_menus (id, name, slug, icon, url, parent_id, sort_order, is_active, created_at, updated_at) VALUES
(2, 'Role & Permissions', 'role-permissions', 'ri-shield-user-line', NULL, NULL, 2, 1, NOW(), NOW());

-- Role & Permissions Children
INSERT INTO admin_menus (id, name, slug, icon, url, parent_id, sort_order, is_active, created_at, updated_at) VALUES
(3, 'Admin Roles', 'admin-roles', 'ri-shield-check-line', '/admin/admin-roles', 2, 1, 1, NOW(), NOW()),
(4, 'Admin Permissions', 'admin-permissions', 'ri-key-line', '/admin/admin-permissions', 2, 2, 1, NOW(), NOW()),
(5, 'Menu Permissions', 'menu-permissions', 'ri-links-line', '/admin/admin-menu-permissions', 2, 3, 1, NOW(), NOW()),
(6, 'Role Menu Permissions', 'role-menu-permissions', 'ri-shield-star-line', '/admin/admin-role-menu-permissions', 2, 4, 1, NOW(), NOW()),
(7, 'Admin Menus', 'admin-menus', 'ri-menu-line', '/admin/admin-menus', 2, 5, 1, NOW(), NOW());

-- Admin (Root Menu)
INSERT INTO admin_menus (id, name, slug, icon, url, parent_id, sort_order, is_active, created_at, updated_at) VALUES
(8, 'Admin', 'admin', 'ri-admin-line', NULL, NULL, 3, 1, NOW(), NOW());

-- Admin Child (Single child with all actions)
INSERT INTO admin_menus (id, name, slug, icon, url, parent_id, sort_order, is_active, created_at, updated_at) VALUES
(9, 'Admins', 'admins', 'ri-team-line', '/admin/admins', 8, 1, 1, NOW(), NOW());

-- ========================================
-- 3. INSERT MENU-PERMISSION MAPPINGS
-- ========================================

-- Dashboard
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(1, 1, NOW(), NOW()); -- Dashboard → Access

-- Role & Permissions (Parent)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(2, 1, NOW(), NOW()); -- Role & Permissions → Access

-- Admin Roles
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(3, 1, NOW(), NOW()), -- Access
(3, 2, NOW(), NOW()), -- Create
(3, 3, NOW(), NOW()), -- Edit
(3, 4, NOW(), NOW()), -- View
(3, 5, NOW(), NOW()); -- Delete

-- Admin Permissions
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(4, 1, NOW(), NOW()), -- Access
(4, 2, NOW(), NOW()), -- Create
(4, 3, NOW(), NOW()), -- Edit
(4, 4, NOW(), NOW()), -- View
(4, 5, NOW(), NOW()); -- Delete

-- Menu Permissions
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(5, 1, NOW(), NOW()), -- Access
(5, 2, NOW(), NOW()), -- Create
(5, 3, NOW(), NOW()), -- Edit
(5, 4, NOW(), NOW()), -- View
(5, 5, NOW(), NOW()); -- Delete

-- Role Menu Permissions
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(6, 1, NOW(), NOW()), -- Access
(6, 2, NOW(), NOW()), -- Create
(6, 3, NOW(), NOW()), -- Edit
(6, 4, NOW(), NOW()), -- View
(6, 5, NOW(), NOW()); -- Delete

-- Admin Menus
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(7, 1, NOW(), NOW()), -- Access
(7, 2, NOW(), NOW()), -- Create
(7, 3, NOW(), NOW()), -- Edit
(7, 4, NOW(), NOW()), -- View
(7, 5, NOW(), NOW()); -- Delete

-- Admin (Parent)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(8, 1, NOW(), NOW()); -- Access

-- Admins (Child with ALL actions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(9, 1, NOW(), NOW()), -- Access (view page/menu)
(9, 2, NOW(), NOW()), -- Create (create button)
(9, 3, NOW(), NOW()), -- Edit (edit icon)
(9, 4, NOW(), NOW()), -- View (view icon)
(9, 5, NOW(), NOW()); -- Delete (delete icon)

-- ========================================
-- 4. ASSIGN TO SUPER ADMIN ROLE (All Permissions)
-- ========================================

-- Get Super Admin role ID by slug and assign all permissions
INSERT INTO admin_role_menu_permission (role_id, menu_permission_id, allow, created_at, updated_at)
SELECT 
    (SELECT id FROM admin_roles WHERE slug = 'super_admin') as role_id,
    id as menu_permission_id,
    1 as allow,
    NOW() as created_at,
    NOW() as updated_at
FROM admin_menu_permission;

-- ========================================
-- VERIFICATION QUERIES
-- ========================================

-- Check menus
SELECT * FROM admin_menus ORDER BY parent_id, sort_order;

-- Check permissions
SELECT * FROM admin_permissions;

-- Check menu-permission mappings
SELECT 
    m.name as menu_name, 
    p.name as permission_name 
FROM admin_menu_permission mp
JOIN admin_menus m ON mp.menu_id = m.id
JOIN admin_permissions p ON mp.permission_id = p.id
ORDER BY m.id, p.id;

-- Check role assignments
SELECT 
    r.name as role_name,
    m.name as menu_name,
    p.name as permission_name,
    rmp.allow
FROM admin_role_menu_permission rmp
JOIN admin_roles r ON rmp.role_id = r.id
JOIN admin_menu_permission mp ON rmp.menu_permission_id = mp.id
JOIN admin_menus m ON mp.menu_id = m.id
JOIN admin_permissions p ON mp.permission_id = p.id
ORDER BY r.id, m.id, p.id;

