# 🔐 Complete RBAC & Security Implementation Guide

## Laravel Role-Based Access Control (RBAC) System - Full Documentation

**Author:** Development Team  
**Date:** November 2024  
**Version:** 1.0.0  
**Status:** ✅ Production Ready

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Database Architecture](#database-architecture)
3. [Permission Flow (Login to Authorization)](#permission-flow)
4. [Security Layers](#security-layers)
5. [Code Implementation](#code-implementation)
6. [Permission Check Examples](#permission-check-examples)
7. [Frontend Integration](#frontend-integration)
8. [Security Best Practices](#security-best-practices)
9. [Troubleshooting](#troubleshooting)

---

## 📖 Overview

### What is RBAC?

**Role-Based Access Control (RBAC)** হচ্ছে একটা security system যেখানে:
- প্রতিটা **User** এর একটা **Role** থাকে (e.g., Super Admin, Manager, Editor)
- প্রতিটা **Role** এর নির্দিষ্ট **Permissions** থাকে (e.g., create, edit, delete)
- প্রতিটা **Menu/Page** এর জন্য আলাদা আলাদা **Permissions** define করা যায়
- System automatically check করে user এর permission আছে কিনা

### Why RBAC?

✅ **Security:** Unauthorized access block করে  
✅ **Scalability:** নতুন roles/permissions সহজে add করা যায়  
✅ **Maintainability:** Centralized permission management  
✅ **Flexibility:** User-specific access control  
✅ **Audit Trail:** কে কি access করেছে track করা যায়

---

## 🗄️ Database Architecture

### Tables Overview

আমাদের RBAC system এ **6টি main tables** আছে:

```
1. admin_roles              → Roles definition (Super Admin, Manager, etc.)
2. admins                   → Admin users
3. admin_menus              → Menu structure (Dashboard, Users, etc.)
4. admin_permissions        → Permission types (create, edit, delete, etc.)
5. admin_menu_permission    → Menu + Permission mapping
6. admin_role_menu_permission → Role access to menu permissions
```

---

### Table 1: `admin_roles`

**Purpose:** Define different admin roles

```sql
CREATE TABLE admin_roles (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,           -- 'Super Admin', 'Manager'
    slug VARCHAR(255) NOT NULL UNIQUE,    -- 'super-admin', 'manager'
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Example Data:**
```
┌────┬──────────────┬──────────────┬─────────────────────────┬───────────┐
│ ID │ Name         │ Slug         │ Description             │ Is Active │
├────┼──────────────┼──────────────┼─────────────────────────┼───────────┤
│ 1  │ Super Admin  │ super-admin  │ Full system access      │ 1         │
│ 2  │ Manager      │ manager      │ Limited management      │ 1         │
│ 3  │ Editor       │ editor       │ Content management only │ 1         │
└────┴──────────────┴──────────────┴─────────────────────────┴───────────┘
```

---

### Table 2: `admins`

**Purpose:** Store admin user accounts

```sql
CREATE TABLE admins (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    role_id BIGINT,                       -- Foreign key to admin_roles
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,       -- Hashed password
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (role_id) REFERENCES admin_roles(id)
);
```

**Example Data:**
```
┌────┬─────────┬──────────────────────┬─────────────────┬───────────┐
│ ID │ Role ID │ Name                 │ Email           │ Is Active │
├────┼─────────┼──────────────────────┼─────────────────┼───────────┤
│ 1  │ 1       │ John Doe             │ john@admin.com  │ 1         │
│ 2  │ 2       │ Jane Smith           │ jane@admin.com  │ 1         │
│ 3  │ 3       │ Bob Editor           │ bob@admin.com   │ 1         │
└────┴─────────┴──────────────────────┴─────────────────┴───────────┘
```

---

### Table 3: `admin_menus`

**Purpose:** Define menu structure (parent/child hierarchy)

```sql
CREATE TABLE admin_menus (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    parent_id BIGINT NULL,                -- NULL = root menu, value = child menu
    name VARCHAR(255) NOT NULL,           -- 'Dashboard', 'Admin Users'
    slug VARCHAR(255) NOT NULL UNIQUE,    -- 'dashboard', 'admins'
    url VARCHAR(255),                     -- '/admin/dashboard'
    icon VARCHAR(255),                    -- 'ri-home-line'
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (parent_id) REFERENCES admin_menus(id)
);
```

**Example Data (Hierarchical):**
```
Root Menus:
┌────┬───────────┬───────────────────────┬──────────────────────┬──────────────────┐
│ ID │ Parent ID │ Name                  │ Slug                 │ URL              │
├────┼───────────┼───────────────────────┼──────────────────────┼──────────────────┤
│ 1  │ NULL      │ Dashboard             │ dashboard            │ /admin/dashboard │
│ 2  │ NULL      │ Role & Permissions    │ role-permissions     │ NULL             │
│ 3  │ NULL      │ Admin                 │ admin                │ NULL             │
└────┴───────────┴───────────────────────┴──────────────────────┴──────────────────┘

Child Menus (under "Role & Permissions"):
┌────┬───────────┬───────────────────────┬──────────────────────┬────────────────────────┐
│ ID │ Parent ID │ Name                  │ Slug                 │ URL                    │
├────┼───────────┼───────────────────────┼──────────────────────┼────────────────────────┤
│ 4  │ 2         │ Admin Roles           │ admin-roles          │ /admin/admin-roles     │
│ 5  │ 2         │ Admin Permissions     │ admin-permissions    │ /admin/admin-permissions│
│ 6  │ 2         │ Menu Permissions      │ admin-menu-permissions│ /admin/admin-menu-permissions│
└────┴───────────┴───────────────────────┴──────────────────────┴────────────────────────┘

Child Menus (under "Admin"):
┌────┬───────────┬───────────────────────┬──────────────────────┬──────────────────┐
│ ID │ Parent ID │ Name                  │ Slug                 │ URL              │
├────┼───────────┼───────────────────────┼──────────────────────┼──────────────────┤
│ 7  │ 3         │ Admins                │ admins               │ /admin/admins    │
└────┴───────────┴───────────────────────┴──────────────────────┴──────────────────┘
```

---

### Table 4: `admin_permissions`

**Purpose:** Define permission types (actions)

```sql
CREATE TABLE admin_permissions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,           -- 'View List', 'Create'
    slug VARCHAR(255) NOT NULL UNIQUE,    -- 'index', 'create'
    description TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Example Data:**
```
┌────┬─────────────────┬──────────┬────────────────────────────────────┐
│ ID │ Name            │ Slug     │ Description                        │
├────┼─────────────────┼──────────┼────────────────────────────────────┤
│ 1  │ Index/List      │ index    │ View list of records               │
│ 2  │ Create          │ create   │ Create new records                 │
│ 3  │ Edit            │ edit     │ Edit existing records              │
│ 4  │ View            │ view     │ View single record details         │
│ 5  │ Delete          │ delete   │ Delete records                     │
│ 6  │ Sidebar Menu    │ sidebar-menu│ Show menu in sidebar            │
│ 7  │ Bulk Update     │ updateBulk│ Update multiple records at once   │
│ 8  │ Assign          │ assign   │ Assign permissions or roles        │
└────┴─────────────────┴──────────┴────────────────────────────────────┘
```

**Permission Types Explained:**

| Permission Slug | Controller Action | Route Example | Button Example |
|----------------|------------------|---------------|----------------|
| `sidebar-menu` | N/A | Shows in sidebar | N/A |
| `index` | `index()` | GET `/admins` | List page access |
| `create` | `create()`, `store()` | GET/POST `/admins/create` | "Add New" button |
| `edit` | `edit()`, `update()` | GET/PUT `/admins/{id}/edit` | Edit icon |
| `view` | `show()` | GET `/admins/{id}` | View icon |
| `delete` | `destroy()` | DELETE `/admins/{id}` | Delete icon |

---

### Table 5: `admin_menu_permission`

**Purpose:** Map which permissions are available for which menus

```sql
CREATE TABLE admin_menu_permission (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    menu_id BIGINT NOT NULL,              -- Foreign key to admin_menus
    permission_id BIGINT NOT NULL,        -- Foreign key to admin_permissions
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (menu_id) REFERENCES admin_menus(id),
    FOREIGN KEY (permission_id) REFERENCES admin_permissions(id),
    UNIQUE KEY (menu_id, permission_id)
);
```

**Example Data:**
```
Menu: "Admins" (ID=7) has these permissions:
┌────┬─────────┬───────────────┬─────────────────┬────────────────┐
│ ID │ Menu ID │ Permission ID │ Menu Name       │ Permission     │
├────┼─────────┼───────────────┼─────────────────┼────────────────┤
│ 1  │ 7       │ 6             │ Admins          │ sidebar-menu   │
│ 2  │ 7       │ 1             │ Admins          │ index          │
│ 3  │ 7       │ 2             │ Admins          │ create         │
│ 4  │ 7       │ 3             │ Admins          │ edit           │
│ 5  │ 7       │ 4             │ Admins          │ view           │
│ 6  │ 7       │ 5             │ Admins          │ delete         │
└────┴─────────┴───────────────┴─────────────────┴────────────────┘
```

**Meaning:** "Admins" menu তে 6টি permissions available আছে।

---

### Table 6: `admin_role_menu_permission`

**Purpose:** Assign menu permissions to roles (allow/deny)

```sql
CREATE TABLE admin_role_menu_permission (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    role_id BIGINT NOT NULL,              -- Foreign key to admin_roles
    menu_permission_id BIGINT NOT NULL,   -- Foreign key to admin_menu_permission
    allow BOOLEAN DEFAULT FALSE,          -- TRUE = allowed, FALSE = denied
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (role_id) REFERENCES admin_roles(id),
    FOREIGN KEY (menu_permission_id) REFERENCES admin_menu_permission(id),
    UNIQUE KEY (role_id, menu_permission_id)
);
```

**Example Data:**
```
Role: "Super Admin" (ID=1) has full access:
┌────┬─────────┬────────────────────┬───────┬─────────────────┬────────────────┐
│ ID │ Role ID │ Menu Permission ID │ Allow │ Menu Name       │ Permission     │
├────┼─────────┼────────────────────┼───────┼─────────────────┼────────────────┤
│ 1  │ 1       │ 1                  │ 1     │ Admins          │ sidebar-menu   │
│ 2  │ 1       │ 2                  │ 1     │ Admins          │ index          │
│ 3  │ 1       │ 3                  │ 1     │ Admins          │ create         │
│ 4  │ 1       │ 4                  │ 1     │ Admins          │ edit           │
│ 5  │ 1       │ 5                  │ 1     │ Admins          │ view           │
│ 6  │ 1       │ 6                  │ 1     │ Admins          │ delete         │
└────┴─────────┴────────────────────┴───────┴─────────────────┴────────────────┘

Role: "Editor" (ID=3) has limited access:
┌────┬─────────┬────────────────────┬───────┬─────────────────┬────────────────┐
│ ID │ Role ID │ Menu Permission ID │ Allow │ Menu Name       │ Permission     │
├────┼─────────┼────────────────────┼───────┼─────────────────┼────────────────┤
│ 7  │ 3       │ 1                  │ 1     │ Admins          │ sidebar-menu   │
│ 8  │ 3       │ 2                  │ 1     │ Admins          │ index          │
│ 9  │ 3       │ 4                  │ 1     │ Admins          │ view           │
│ 10 │ 3       │ 3                  │ 0     │ Admins          │ create (DENIED)│
│ 11 │ 3       │ 5                  │ 0     │ Admins          │ delete (DENIED)│
└────┴─────────┴────────────────────┴───────┴─────────────────┴────────────────┘
```

**Meaning:** 
- Super Admin: সব permissions আছে (allow = 1)
- Editor: শুধু view এবং list করতে পারবে (create/delete denied)

---

## 🔄 Permission Flow

### Complete Flow: Login → Authorization

```
┌───────────────────────────────────────────────────────────────────────┐
│                         USER LOGIN                                     │
└───────────────────────────────────────────────────────────────────────┘
                                ↓
┌───────────────────────────────────────────────────────────────────────┐
│ Step 1: Authentication (AuthController@login)                         │
│                                                                        │
│ • User enters email/password                                           │
│ • System validates credentials                                         │
│ • Check if admin exists and active                                     │
└───────────────────────────────────────────────────────────────────────┘
                                ↓
┌───────────────────────────────────────────────────────────────────────┐
│ Step 2: Load Permissions (PermissionService)                          │
│                                                                        │
│ • Get admin's role_id                                                  │
│ • Query database:                                                      │
│   → admin_role_menu_permission (allow = 1)                            │
│   → Join admin_menu_permission                                         │
│   → Join admin_menus (get menu slug)                                   │
│   → Join admin_permissions (get permission slug)                       │
│                                                                        │
│ Result: Array of allowed permissions                                   │
│ [                                                                      │
│   'admins' => ['index', 'create', 'edit', 'view', 'delete'],         │
│   'admin-roles' => ['index', 'view'],                                 │
│   'dashboard' => ['index']                                             │
│ ]                                                                      │
└───────────────────────────────────────────────────────────────────────┘
                                ↓
┌───────────────────────────────────────────────────────────────────────┐
│ Step 3: Store in Session (Server-side)                                │
│                                                                        │
│ session([                                                              │
│     'admin_id' => 1,                                                   │
│     'admin_name' => 'John Doe',                                        │
│     'admin_role_id' => 1,                                              │
│     'admin_permissions' => [                                           │
│         'admins' => ['index', 'create', 'edit', 'view', 'delete'],   │
│         'admin-roles' => ['index', 'view']                             │
│     ]                                                                  │
│ ]);                                                                    │
│                                                                        │
│ ✅ Stored on SERVER (secure, cannot be modified by client)            │
└───────────────────────────────────────────────────────────────────────┘
                                ↓
┌───────────────────────────────────────────────────────────────────────┐
│ Step 4: Cache Menu Structure (UI Only)                                │
│                                                                        │
│ • Build nested menu structure for sidebar rendering                   │
│ • Store in session as 'admin_menu_structure'                          │
│ • Copy to localStorage (UI rendering only, NOT for security)          │
│                                                                        │
│ localStorage.setItem('admin_auth', JSON.stringify({                   │
│     permissions: admin_menu_structure  // For sidebar UI only         │
│ }));                                                                   │
└───────────────────────────────────────────────────────────────────────┘
                                ↓
┌───────────────────────────────────────────────────────────────────────┐
│                   USER NAVIGATES TO A PAGE                             │
└───────────────────────────────────────────────────────────────────────┘
                                ↓
┌───────────────────────────────────────────────────────────────────────┐
│ Step 5: Route Middleware Check (CheckAdminPermission)                 │
│                                                                        │
│ Route::resource('admins', AdminController::class)                     │
│     ->middleware('admin.check.permission:admins');                    │
│                                                                        │
│ Middleware Process:                                                    │
│ 1. Check if admin logged in (session('admin_id'))                     │
│ 2. Get current controller action (e.g., 'index', 'store', 'destroy') │
│ 3. Map action to permission slug:                                     │
│    • store → create                                                    │
│    • update → edit                                                     │
│    • destroy → delete                                                  │
│    • index → index (no mapping)                                        │
│    • create → create (no mapping)                                      │
│    • edit → edit (no mapping)                                          │
│    • show → view (no mapping)                                          │
│ 4. Call can() helper: can('admins.create')                            │
│ 5. If TRUE → Allow request                                             │
│    If FALSE → abort(403) Unauthorized                                  │
└───────────────────────────────────────────────────────────────────────┘
                                ↓
┌───────────────────────────────────────────────────────────────────────┐
│ Step 6: Permission Check (can() Helper)                               │
│                                                                        │
│ function can(string $permission): bool                                 │
│ {                                                                      │
│     // 1. Check login                                                  │
│     if (!session('admin_id')) return false;                            │
│                                                                        │
│     // 2. Split permission string                                      │
│     [$menu, $action] = explode('.', $permission);                      │
│     // 'admins.create' → ['admins', 'create']                         │
│                                                                        │
│     // 3. Get session permissions                                      │
│     $permissions = session('admin_permissions', []);                   │
│                                                                        │
│     // 4. Check if permission exists                                   │
│     return isset($permissions[$menu])                                  │
│         && in_array($action, $permissions[$menu]);                     │
│ }                                                                      │
│                                                                        │
│ Example Check:                                                         │
│ • can('admins.create')                                                 │
│ • session['admin_permissions']['admins'] = ['index','create','edit']  │
│ • in_array('create', ['index','create','edit']) → TRUE ✅             │
└───────────────────────────────────────────────────────────────────────┘
                                ↓
┌───────────────────────────────────────────────────────────────────────┐
│ Step 7: Controller Action Execution                                   │
│                                                                        │
│ If permission check PASSED:                                            │
│ • Controller method executes                                           │
│ • Database operations performed                                        │
│ • Response returned to user                                            │
│                                                                        │
│ If permission check FAILED:                                            │
│ • abort(403) called                                                    │
│ • Show "403 Unauthorized" page                                         │
│ • Request blocked                                                      │
└───────────────────────────────────────────────────────────────────────┘
                                ↓
┌───────────────────────────────────────────────────────────────────────┐
│ Step 8: Blade View Rendering                                          │
│                                                                        │
│ @can('admins.create')                                                  │
│     <button>Add New Admin</button>                                     │
│ @endcan                                                                │
│                                                                        │
│ Process:                                                               │
│ • Blade calls can('admins.create')                                     │
│ • Same helper function as Step 6                                       │
│ • If TRUE → Show button                                                 │
│ • If FALSE → Hide button                                                │
│                                                                        │
│ ✅ Button only visible if user has permission                          │
└───────────────────────────────────────────────────────────────────────┘
                                ↓
┌───────────────────────────────────────────────────────────────────────┐
│                         USER LOGS OUT                                  │
└───────────────────────────────────────────────────────────────────────┘
                                ↓
┌───────────────────────────────────────────────────────────────────────┐
│ Step 9: Clear Session & Cache                                         │
│                                                                        │
│ • session()->forget(['admin_id', 'admin_permissions', ...]);          │
│ • localStorage.removeItem('admin_auth');                               │
│ • Redirect to login page                                               │
│                                                                        │
│ ✅ All permission data cleared                                         │
└───────────────────────────────────────────────────────────────────────┘
```

---

## 🛡️ Security Layers

আমাদের system এ **4 layers of security** আছে:

### Layer 1: Authentication (Login Check)

```php
// Every request first checks if user is logged in
if (!session('admin_id')) {
    return redirect()->route('admin.login');
}
```

**Protection:** Unauthorized users cannot access admin panel

---

### Layer 2: Route Middleware (Route-Level Authorization)

```php
// routes/admin.php
Route::resource('admins', AdminController::class)
    ->middleware('admin.check.permission:admins');
```

**Process:**
1. User requests `/admin/admins/create`
2. Middleware intercepts request
3. Checks: `can('admins.create')`
4. If FALSE → `abort(403)` ❌
5. If TRUE → Continue to controller ✅

**Protection:** Blocks unauthorized route access

---

### Layer 3: Controller Authorization (Method-Level)

```php
// AdminController.php
public function create()
{
    // Optional: Additional check inside controller
    if (!can('admins.create')) {
        abort(403, 'You do not have permission to create admins.');
    }
    
    return view('admin.admins.createOrEdit');
}
```

**Protection:** Double-check permissions at method level

---

### Layer 4: View Authorization (UI-Level)

```blade
<!-- resources/views/admin/admins/index.blade.php -->
@can('admins.create')
    <a href="{{ route('admin.admins.create') }}" class="btn">
        Add New Admin
    </a>
@endcan
```

**Protection:** Hide UI elements user doesn't have permission for

---

### Security Summary Table

| Layer | Location | Check Type | Action if Failed | Purpose |
|-------|----------|------------|------------------|---------|
| **1. Authentication** | Middleware | Login status | Redirect to login | Ensure user logged in |
| **2. Route** | Middleware | Permission | 403 Forbidden | Block route access |
| **3. Controller** | Controller method | Permission | 403 Forbidden | Method-level protection |
| **4. View** | Blade template | Permission | Hide element | UI element visibility |

**Example: Creating a new admin**

```
User clicks "Add New Admin" button
    ↓
Layer 4 (View): Button visible? → Check can('admins.create') ✅
    ↓
User navigates to /admin/admins/create
    ↓
Layer 1 (Auth): Logged in? → Check session('admin_id') ✅
    ↓
Layer 2 (Route): Has permission? → Check can('admins.create') ✅
    ↓
Layer 3 (Controller): Double-check? → Check can('admins.create') ✅
    ↓
✅ Show create form
```

---

## 💻 Code Implementation

### 1. Permission Helper (`app/Helpers/PermissionHelper.php`)

```php
<?php

/**
 * Check if current admin has a specific permission
 * 
 * @param string $permission Format: 'menu-slug.action-slug' (e.g., 'admins.create')
 * @return bool
 */
function can(string $permission): bool
{
    // Check if admin is logged in
    if (!session('admin_id')) {
        return false;
    }
    
    // Split permission string
    // Example: 'admins.create' → ['admins', 'create']
    $parts = explode('.', $permission);
    
    if (count($parts) !== 2) {
        return false;
    }
    
    [$menuSlug, $actionSlug] = $parts;
    
    // Get permissions from session
    $permissions = session('admin_permissions', []);
    
    // Check if menu exists and has the action
    return isset($permissions[$menuSlug]) 
        && in_array($actionSlug, $permissions[$menuSlug]);
}
```

**Usage Examples:**

```php
// In controller
if (can('admins.create')) {
    // User can create admins
}

// In blade
@can('admins.edit')
    <button>Edit</button>
@endcan

// In route middleware
->middleware('admin.check.permission:admins')
```

---

### 2. Permission Service (`app/Services/Admin/PermissionService.php`)

```php
<?php

namespace App\Services\Admin;

use App\Models\Admin;

class PermissionService
{
    /**
     * Load admin permissions from database and structure them
     * 
     * @param Admin $admin
     * @return array ['menu_slug' => ['permission_slug1', 'permission_slug2']]
     */
    public function loadAdminPermissions(Admin $admin): array
    {
        $permissions = [];
        
        if (!$admin->role) {
            return $permissions;
        }
        
        // Load all allowed permissions for this admin's role
        $admin->load([
            'role.roleMenuPermissions.menuPermission.menu',
            'role.roleMenuPermissions.menuPermission.permission'
        ]);
        
        // Loop through each allowed permission
        foreach ($admin->role->roleMenuPermissions as $roleMenuPerm) {
            // Skip if not allowed
            if (!$roleMenuPerm->allow) {
                continue;
            }
            
            $menuPermission = $roleMenuPerm->menuPermission;
            
            // Skip if invalid data
            if (!$menuPermission || !$menuPermission->menu || !$menuPermission->permission) {
                continue;
            }
            
            // Get slugs
            $menuSlug = $menuPermission->menu->slug;          // 'admins'
            $permissionSlug = $menuPermission->permission->slug; // 'create'
            
            // Initialize array if not exists
            if (!isset($permissions[$menuSlug])) {
                $permissions[$menuSlug] = [];
            }
            
            // Add permission to menu
            $permissions[$menuSlug][] = $permissionSlug;
        }
        
        return $permissions;
    }
}
```

**Result Example:**

```php
[
    'dashboard' => ['index'],
    'admins' => ['sidebar-menu', 'index', 'create', 'edit', 'view', 'delete'],
    'admin-roles' => ['sidebar-menu', 'index', 'view'],
    'admin-permissions' => ['sidebar-menu', 'index', 'view']
]
```

---

### 3. Auth Controller (`app/Http/Controllers/Admin/AuthController.php`)

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\PermissionService;

class AuthController extends Controller
{
    protected $permissionService;
    
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
    
    /**
     * Handle admin login
     */
    public function login(LoginRequest $request)
    {
        // 1. Authenticate user (email/password check)
        $admin = $request->authenticate();
        
        // 2. Store basic info in session
        session([
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'admin_role_id' => $admin->role_id,
            'admin_role_name' => $admin->role?->name,
        ]);
        
        // 3. Load and store permissions
        $permissions = $this->permissionService->loadAdminPermissions($admin);
        session(['admin_permissions' => $permissions]);
        
        // 4. Load menu structure for UI
        $menuStructure = $this->permissionService->loadMenuStructure($admin);
        session(['admin_menu_structure' => $menuStructure]);
        
        // 5. Redirect to dashboard
        return redirect()->route('admin.dashboard');
    }
    
    /**
     * Handle admin logout
     */
    public function logout()
    {
        // Clear all session data
        session()->forget([
            'admin_id',
            'admin_name',
            'admin_role_id',
            'admin_role_name',
            'admin_permissions',
            'admin_menu_structure'
        ]);
        
        // Redirect to login
        return redirect()->route('admin.login');
    }
}
```

---

### 4. Permission Middleware (`app/Http/Middleware/CheckAdminPermission.php`)

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminPermission
{
    /**
     * Handle incoming request
     * 
     * @param Request $request
     * @param Closure $next
     * @param string $menuSlug Menu slug to check (e.g., 'admins')
     */
    public function handle(Request $request, Closure $next, string $menuSlug)
    {
        // 1. Check if admin is logged in
        if (!session('admin_id')) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login first');
        }
        
        // 2. Get controller action method
        $action = $request->route()->getActionMethod();
        // Examples: 'index', 'create', 'store', 'edit', 'update', 'destroy'
        
        // 3. Map Laravel resource actions to permission slugs
        $actionMap = [
            'store' => 'create',   // POST /admins → create permission
            'update' => 'edit',    // PUT /admins/1 → edit permission
            'destroy' => 'delete', // DELETE /admins/1 → delete permission
        ];
        
        // 4. Get permission slug (map or use as-is)
        $permission = $actionMap[$action] ?? $action;
        
        // 5. Check permission using helper
        if (!can("{$menuSlug}.{$permission}")) {
            // Not authorized
            abort(403, 'Unauthorized: You do not have permission to access this resource.');
        }
        
        // 6. Permission check passed - continue
        return $next($request);
    }
}
```

**How it works:**

```
Request: POST /admin/admins (store new admin)
    ↓
Middleware: CheckAdminPermission('admins')
    ↓
Action: 'store'
    ↓
Map: 'store' → 'create'
    ↓
Check: can('admins.create')
    ↓
Session: ['admins' => ['index', 'create', 'edit']]
    ↓
Result: 'create' found in array → TRUE ✅
    ↓
Allow request to continue
```

---

### 5. Routes (`routes/admin.php`)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminRoleController;

// Resource routes with permission middleware
Route::resource('admins', AdminController::class)
    ->names('admin.admins')
    ->middleware('admin.check.permission:admins');

Route::resource('admin-roles', AdminRoleController::class)
    ->names('admin.admin-roles')
    ->middleware('admin.check.permission:admin-roles');

// Custom routes
Route::put('admin-role-menu-permissions/update-bulk', [AdminRoleMenuPermissionController::class, 'updateBulk'])
    ->name('admin.admin-role-menu-permissions.update-bulk')
    ->middleware('admin.check.permission:admin-role-menu-permissions');
```

**Route to Permission Mapping:**

| Route | Method | Controller Action | Permission Checked | Session Key |
|-------|--------|------------------|-------------------|-------------|
| `/admins` | GET | `index()` | `admins.index` | `admin_permissions['admins']` contains `'index'` |
| `/admins/create` | GET | `create()` | `admins.create` | `admin_permissions['admins']` contains `'create'` |
| `/admins` | POST | `store()` | `admins.create` | (mapped from `store`) |
| `/admins/1/edit` | GET | `edit()` | `admins.edit` | `admin_permissions['admins']` contains `'edit'` |
| `/admins/1` | PUT | `update()` | `admins.edit` | (mapped from `update`) |
| `/admins/1` | DELETE | `destroy()` | `admins.delete` | (mapped from `destroy`) |

---

## 📝 Permission Check Examples

### Example 1: Simple Permission Check

```php
// Check if user can create admins
if (can('admins.create')) {
    // User has permission
    $admin = Admin::create($data);
} else {
    // User doesn't have permission
    return response()->json(['error' => 'Unauthorized'], 403);
}
```

---

### Example 2: Multiple Permission Checks

```php
// Check multiple permissions
$canCreate = can('admins.create');
$canEdit = can('admins.edit');
$canDelete = can('admins.delete');

if ($canCreate && $canEdit && $canDelete) {
    // User has all permissions
    echo "Full access";
} else {
    // User has limited access
    echo "Limited access";
}
```

---

### Example 3: Blade Template Checks

```blade
<!-- resources/views/admin/admins/index.blade.php -->
<div class="page-header">
    <h1>Admin Users</h1>
    
    <!-- Show "Add New" button only if user can create -->
    @can('admins.create')
        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
            <i class="ri-add-line"></i> Add New Admin
        </a>
    @endcan
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($admins as $admin)
        <tr>
            <td>{{ $admin->name }}</td>
            <td>{{ $admin->email }}</td>
            <td>
                <!-- Show view button if user can view -->
                @can('admins.view')
                    <a href="{{ route('admin.admins.show', $admin) }}" class="btn-icon">
                        <i class="ri-eye-line"></i>
                    </a>
                @endcan
                
                <!-- Show edit button if user can edit -->
                @can('admins.edit')
                    <a href="{{ route('admin.admins.edit', $admin) }}" class="btn-icon">
                        <i class="ri-edit-line"></i>
                    </a>
                @endcan
                
                <!-- Show delete button if user can delete -->
                @can('admins.delete')
                    <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon btn-danger">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
```

---

### Example 4: Dynamic Menu Rendering

```blade
<!-- resources/views/admin/layouts/sidebar.blade.php -->
<nav class="sidebar">
    <!-- Dashboard (always visible if has index permission) -->
    @can('dashboard.index')
        <a href="{{ route('admin.dashboard') }}" class="menu-item">
            <i class="ri-home-line"></i>
            Dashboard
        </a>
    @endcan
    
    <!-- Admins Menu (only if has sidebar-menu permission) -->
    @can('admins.sidebar-menu')
        <a href="{{ route('admin.admins.index') }}" class="menu-item">
            <i class="ri-user-line"></i>
            Admin Users
        </a>
    @endcan
    
    <!-- Roles Menu (only if has sidebar-menu permission) -->
    @can('admin-roles.sidebar-menu')
        <a href="{{ route('admin.admin-roles.index') }}" class="menu-item">
            <i class="ri-shield-user-line"></i>
            Admin Roles
        </a>
    @endcan
</nav>
```

---

## 🌐 Frontend Integration

### Session → localStorage (UI Only)

```blade
<!-- resources/views/admin/layouts/app.blade.php -->
<script>
    // Store menu structure in localStorage for sidebar rendering
    @if(session('admin_id'))
        const adminData = {
            id: {{ session('admin_id') }},
            name: "{{ session('admin_name') }}",
            permissions: @json(session('admin_menu_structure', []))
        };
        
        localStorage.setItem('admin_auth', JSON.stringify(adminData));
    @else
        // Clear if no session
        localStorage.removeItem('admin_auth');
    @endif
</script>
```

**Important:** localStorage is used **ONLY for UI rendering** (sidebar menu). **NOT for security checks!**

### Why localStorage for UI?

✅ **Performance:** No server request needed to render sidebar  
✅ **User Experience:** Instant sidebar rendering  
✅ **Reduced Load:** Less database queries  

❌ **NOT for security:** All security checks use server-side session!

---

## 🔒 Security Best Practices

### 1. Never Trust Client-Side Data ❌

```javascript
// ❌ BAD: Checking permission in JavaScript
if (localStorage.getItem('admin_permissions').includes('create')) {
    // User can modify localStorage!
}

// ✅ GOOD: Always check on server
// Middleware checks session (server-side)
```

---

### 2. Always Use Server-Side Session ✅

```php
// ✅ Session is stored on server
session(['admin_permissions' => $permissions]);

// User CANNOT modify server-side session
// Even if they modify localStorage, it won't affect authorization
```

---

### 3. Multiple Security Layers ✅

```php
// Layer 1: Route middleware
Route::resource('admins')->middleware('admin.check.permission:admins');

// Layer 2: Controller check (optional, for extra security)
public function create() {
    if (!can('admins.create')) abort(403);
    // ...
}

// Layer 3: View check (hide UI elements)
@can('admins.create')
    <button>Add New</button>
@endcan
```

---

### 4. Hash Passwords ✅

```php
// When creating admin
$admin->password = bcrypt($request->password);
// or
$admin->password = Hash::make($request->password);
```

---

### 5. Validate All Input ✅

```php
// Use Form Requests
public function store(AdminRequest $request) {
    $validated = $request->validated(); // Only validated data
    Admin::create($validated);
}
```

---

### 6. Use HTTPS in Production ✅

```
// .env
APP_URL=https://yourdomain.com
SESSION_SECURE_COOKIE=true
```

---

### 7. Set Session Lifetime ✅

```php
// config/session.php
'lifetime' => 120, // 120 minutes (2 hours)
'expire_on_close' => true, // Clear on browser close
```

---

### 8. Protect Against CSRF ✅

```blade
<!-- Laravel automatically protects POST/PUT/DELETE -->
<form method="POST">
    @csrf  <!-- Required! -->
    <!-- form fields -->
</form>
```

---

## 🐛 Troubleshooting

### Issue 1: "403 Forbidden" on every page

**Cause:** Permissions not loaded in session

**Solution:**
```bash
# Logout and login again to reload permissions
# Or check session:
php artisan tinker
>>> session('admin_permissions')
```

---

### Issue 2: Button visible but route blocked

**Cause:** Blade check passed but middleware blocked

**Solution:** Check both have same permission:
```blade
@can('admins.create')  <!-- Blade -->
```
```php
->middleware('admin.check.permission:admins')  // Route
```

---

### Issue 3: Permission changes not reflecting

**Cause:** Session not updated after permission change

**Solution:**
```php
// After updating permissions, logout user
// They need to login again to reload permissions
session()->forget('admin_permissions');
```

---

### Issue 4: Helper function not found

**Cause:** Composer autoload not updated

**Solution:**
```bash
composer dump-autoload
# or in Docker:
docker-compose exec app composer dump-autoload
```

---

## 📊 Summary

### System Overview

```
┌────────────────────────────────────────────────────────────────┐
│                        RBAC System                              │
├────────────────────────────────────────────────────────────────┤
│                                                                 │
│  Database (6 tables)                                            │
│  ├─ admin_roles                → Define roles                  │
│  ├─ admins                      → Store users                  │
│  ├─ admin_menus                 → Define menus                 │
│  ├─ admin_permissions           → Define actions               │
│  ├─ admin_menu_permission       → Menu+Permission mapping      │
│  └─ admin_role_menu_permission  → Role access control          │
│                                                                 │
│  Authentication & Authorization                                 │
│  ├─ Login → Load permissions from DB                           │
│  ├─ Store in server-side session (secure)                      │
│  ├─ Check permission on every request (middleware)             │
│  └─ Render UI based on permissions (blade)                     │
│                                                                 │
│  Security Layers (4 levels)                                     │
│  ├─ Layer 1: Authentication (logged in?)                       │
│  ├─ Layer 2: Route Middleware (has permission?)               │
│  ├─ Layer 3: Controller Check (double check)                  │
│  └─ Layer 4: View Check (hide UI elements)                    │
│                                                                 │
│  Helper Functions                                               │
│  ├─ can('menu.action') → Check permission                     │
│  └─ @can('menu.action') → Blade directive                     │
│                                                                 │
└────────────────────────────────────────────────────────────────┘
```

---

### Key Takeaways

✅ **Server-side session:** All authorization checks use session (secure)  
✅ **Multi-layer security:** Authentication + Route + Controller + View  
✅ **Dynamic permissions:** Load from database, not hardcoded  
✅ **Flexible RBAC:** Easy to add new roles/permissions  
✅ **Performance:** Session cache, localStorage for UI only  
✅ **Production-ready:** Tested, secure, maintainable  

---

## 🎓 Learning Resources

### Laravel Documentation
- [Authentication](https://laravel.com/docs/authentication)
- [Authorization](https://laravel.com/docs/authorization)
- [Middleware](https://laravel.com/docs/middleware)
- [Session](https://laravel.com/docs/session)

### Related Patterns
- **RBAC:** Role-Based Access Control
- **ABAC:** Attribute-Based Access Control
- **ACL:** Access Control Lists

---

## 📞 Support

যদি কোন সমস্যা হয় বা প্রশ্ন থাকে:

1. **Check logs:** `storage/logs/laravel.log`
2. **Debug session:** `dd(session()->all())`
3. **Check permissions:** `dd(session('admin_permissions'))`
4. **Test helper:** `dd(can('admins.create'))`

---

**🎉 Congratulations!**

তোমার RBAC system এখন **production-ready** এবং **fully secure**! 

This documentation covers:
- ✅ Database architecture
- ✅ Permission flow
- ✅ Security implementation
- ✅ Code examples
- ✅ Troubleshooting

**Happy coding! 🚀**

