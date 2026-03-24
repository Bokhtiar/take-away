-- ================================
-- Clean Menu Setup (No Extra Code)
-- ================================

-- Clear old data
TRUNCATE TABLE admin_role_menu_permission;
TRUNCATE TABLE admin_menu_permission;
TRUNCATE TABLE admin_menus;
TRUNCATE TABLE admin_permissions;

-- ================================
-- 1. PERMISSIONS
-- ================================
INSERT INTO admin_permissions (id, name, slug, created_at, updated_at) VALUES
(1, 'Access', 'sidebar-menu', NOW(), NOW()),
(2, 'Create', 'create', NOW(), NOW()),
(3, 'Edit', 'edit', NOW(), NOW()),
(4, 'View', 'view', NOW(), NOW()),
(5, 'Delete', 'delete', NOW(), NOW());

-- ================================
-- 2. MENUS
-- ================================

-- Root: Dashboard (no children)
INSERT INTO admin_menus (id, name, slug, icon, url, parent_id, sort_order, is_active, created_at, updated_at) VALUES
(1, 'Dashboard', 'dashboard', 'ri-dashboard-line', '/admin/dashboard', NULL, 1, 1, NOW(), NOW());

-- Root: Role & Permissions (has children)
INSERT INTO admin_menus (id, name, slug, icon, url, parent_id, sort_order, is_active, created_at, updated_at) VALUES
(2, 'Role & Permissions', 'role-permissions', 'ri-shield-user-line', NULL, NULL, 2, 1, NOW(), NOW());

-- Children of Role & Permissions
INSERT INTO admin_menus (id, name, slug, icon, url, parent_id, sort_order, is_active, created_at, updated_at) VALUES
(3, 'Admin Roles', 'admin-roles', 'ri-shield-check-line', '/admin/admin-roles', 2, 1, 1, NOW(), NOW()),
(4, 'Admin Permissions', 'admin-permissions', 'ri-key-line', '/admin/admin-permissions', 2, 2, 1, NOW(), NOW()),
(5, 'Menu Permissions', 'menu-permissions', 'ri-links-line', '/admin/admin-menu-permissions', 2, 3, 1, NOW(), NOW()),
(6, 'Role Menu Permissions', 'role-menu-permissions', 'ri-shield-star-line', '/admin/admin-role-menu-permissions', 2, 4, 1, NOW(), NOW()),
(7, 'Admin Menus', 'admin-menus', 'ri-menu-line', '/admin/admin-menus', 2, 5, 1, NOW(), NOW());

-- Root: Admin (has children)
INSERT INTO admin_menus (id, name, slug, icon, url, parent_id, sort_order, is_active, created_at, updated_at) VALUES
(8, 'Admin', 'admin', 'ri-admin-line', NULL, NULL, 3, 1, NOW(), NOW());

-- Children of Admin
INSERT INTO admin_menus (id, name, slug, icon, url, parent_id, sort_order, is_active, created_at, updated_at) VALUES
(9, 'Admins', 'admins', 'ri-team-line', '/admin/admins', 8, 1, 1, NOW(), NOW());

-- ================================
-- 3. MENU PERMISSIONS (Each child gets all 5 permissions)
-- ================================

-- Dashboard (root, no children)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES (1, 1, NOW(), NOW());

-- Role & Permissions root
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES (2, 1, NOW(), NOW());

-- Admin Roles child (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(3, 1, NOW(), NOW()), (3, 2, NOW(), NOW()), (3, 3, NOW(), NOW()), (3, 4, NOW(), NOW()), (3, 5, NOW(), NOW());

-- Admin Permissions child (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(4, 1, NOW(), NOW()), (4, 2, NOW(), NOW()), (4, 3, NOW(), NOW()), (4, 4, NOW(), NOW()), (4, 5, NOW(), NOW());

-- Menu Permissions child (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(5, 1, NOW(), NOW()), (5, 2, NOW(), NOW()), (5, 3, NOW(), NOW()), (5, 4, NOW(), NOW()), (5, 5, NOW(), NOW());

-- Role Menu Permissions child (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(6, 1, NOW(), NOW()), (6, 2, NOW(), NOW()), (6, 3, NOW(), NOW()), (6, 4, NOW(), NOW()), (6, 5, NOW(), NOW());

-- Admin Menus child (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(7, 1, NOW(), NOW()), (7, 2, NOW(), NOW()), (7, 3, NOW(), NOW()), (7, 4, NOW(), NOW()), (7, 5, NOW(), NOW());

-- Admin root
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES (8, 1, NOW(), NOW());

-- Admins child (all permissions)
INSERT INTO admin_menu_permission (menu_id, permission_id, created_at, updated_at) VALUES
(9, 1, NOW(), NOW()), (9, 2, NOW(), NOW()), (9, 3, NOW(), NOW()), (9, 4, NOW(), NOW()), (9, 5, NOW(), NOW());

-- ================================
-- 4. ASSIGN TO SUPER ADMIN (all permissions)
-- ================================
INSERT INTO admin_role_menu_permission (role_id, menu_permission_id, allow, created_at, updated_at)
SELECT 
    (SELECT id FROM admin_roles WHERE slug = 'super_admin'),
    id,
    1,
    NOW(),
    NOW()
FROM admin_menu_permission;

