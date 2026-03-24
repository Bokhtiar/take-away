# Menu & Permissions Setup Instructions

## 📋 Prerequisites

Make sure these tables exist:
- ✅ `admin_roles` 
- ✅ `admin_menus`
- ✅ `admin_permissions`
- ✅ `admin_menu_permission`
- ✅ `admin_role_menu_permission`

## 🚀 Setup Steps

### Step 1: Create Super Admin Role

First, make sure Super Admin role exists in your database:

```bash
php artisan db:seed --class=AdminRoleSeeder
```

Or run this SQL:
```sql
INSERT INTO admin_roles (name, slug, description, created_at, updated_at)
VALUES ('Super Admin', 'super_admin', 'Super Administrator with full system access and permissions.', NOW(), NOW());
```

### Step 2: Run Menu & Permissions Seeder

**Option A: Using Laravel Seeder (if PHP 8.2+)**
```bash
php artisan db:seed --class=MenuPermissionSeeder
```

**Option B: Using SQL File (Recommended)**
```bash
mysql -u your_user -p your_database < database/menu_permissions_data.sql
```

Or import via phpMyAdmin:
- File: `database/menu_permissions_data.sql`

### Step 3: Verify

Login with your Super Admin account and check:
1. Browser Console → `✅ Admin data cached to localStorage:`
2. Sidebar → Dynamic menus visible
3. Nested menus work (Role & Permissions, Admin Management)

---

## 📊 What Gets Created

### Menus:
```
├─ Dashboard (single menu)
├─ Role & Permissions (parent)
│  ├─ Admin Roles (child with actions)
│  ├─ Admin Permissions (child with actions)
│  ├─ Menu Permissions (child with actions)
│  ├─ Role Menu Permissions (child with actions)
│  └─ Admin Menus (child with actions)
└─ Admin (parent)
   └─ Admins (child with actions)
      Actions: Create, Edit, View, Delete buttons
```

### Permissions:
- **Access** - Menu visibility
- **Create** - Create records
- **Edit** - Edit records
- **View** - View details
- **Delete** - Delete records

### Role Assignment:
- **Super Admin** → ALL permissions on ALL menus ✅

---

## 🔍 Verification Queries

```sql
-- Check Super Admin permissions
SELECT 
    m.name as menu, 
    p.name as permission,
    rmp.allow
FROM admin_role_menu_permission rmp
JOIN admin_roles r ON rmp.role_id = r.id
JOIN admin_menu_permission mp ON rmp.menu_permission_id = mp.id
JOIN admin_menus m ON mp.menu_id = m.id
JOIN admin_permissions p ON mp.permission_id = p.id
WHERE r.slug = 'super_admin'
ORDER BY m.id, p.id;

-- Count total permissions assigned
SELECT 
    r.name as role,
    COUNT(*) as total_permissions
FROM admin_role_menu_permission rmp
JOIN admin_roles r ON rmp.role_id = r.id
WHERE rmp.allow = 1
GROUP BY r.id;
```

---

## ⚠️ Troubleshooting

### Issue: "Super Admin role not found"
**Solution:** Run AdminRoleSeeder first:
```bash
php artisan db:seed --class=AdminRoleSeeder
```

### Issue: "Sidebar not showing menus"
**Solution:** 
1. Clear browser localStorage
2. Logout and login again
3. Check browser console for errors

### Issue: "Foreign key constraint fails"
**Solution:** Make sure migrations are run:
```bash
php artisan migrate
```

---

## 🎯 Next Steps

1. ✅ Run seeders
2. ✅ Login with Super Admin
3. ✅ Test sidebar menus
4. ✅ Test permissions (create, edit, delete buttons)
5. ✅ Create more roles and assign custom permissions

---

## 📝 Notes

- Super Admin gets **ALL permissions** automatically
- Other roles need manual permission assignment via "Role Menu Permissions" page
- Parent menu permissions can be inherited by children
- You can override child permissions explicitly if needed

