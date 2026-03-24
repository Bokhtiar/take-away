# 🔧 Troubleshooting Guide

## Problem: Sidebar showing old hardcoded menus

### Step 1: Check Database
```bash
# Login to MySQL
mysql -u root -p your_database

# Check if menus exist
SELECT COUNT(*) as total FROM admin_menus;
# Should show: 9 menus

# Check if permissions assigned to Super Admin
SELECT COUNT(*) as total 
FROM admin_role_menu_permission rmp
JOIN admin_roles r ON rmp.role_id = r.id
WHERE r.slug = 'super_admin' AND rmp.allow = 1;
# Should show: 41 permissions
```

If counts are 0, **run the SQL file**:
```bash
mysql -u root -p your_database < database/menu_permissions_data.sql
```

---

### Step 2: Access Debug Page

Open browser and go to:
```
http://your-site/admin/debug-permissions
```

This page will show:
- ✅ Session data
- ✅ Permissions in session
- ✅ LocalStorage data
- ✅ Helper functions status
- ✅ Database counts

**Check each section:**

#### Expected Results:

**1. Session Data:**
```json
{
  "admin_id": 1,
  "admin_name": "Your Name",
  "admin_role_id": 1,
  "admin_role_name": "Super Admin",
  "permissions_count": 9  // Should have 9 menus
}
```

**2. LocalStorage:**
```json
{
  "id": 1,
  "name": "Your Name",
  "role_id": 1,
  "role_name": "Super Admin",
  "permissions": {
    "1": { "menu_name": "Dashboard", ... },
    "2": { "menu_name": "Role & Permissions", ... },
    ...
  }
}
```

**3. Helper Functions:**
```
✅ getAllowedMenus: 9 menus found
✅ buildMenuTree: 3 root menus
✅ hasPermission: Dashboard access = true
```

**4. Database:**
```
✅ Database Counts:
  - Total Menus: 9
  - Total Permissions: 5
  - Total Menu-Permission Mappings: 41
  - Your Role Permissions (allow=1): 41
```

---

### Step 3: Check Browser Console

Open browser DevTools (F12) → Console tab

You should see:
```
✅ Admin data cached to localStorage: {id: 1, ...}
🔧 Sidebar script loaded
🚀 Starting dynamic sidebar render...
📦 Admin Auth Data: {...}
✅ Allowed Menus: (9) [{...}, {...}, ...]
🌲 Menu Tree: (3) [{...}, {...}, {...}]
📝 Generated HTML length: 2500
✅ Menus inserted after dashboard
🎉 Dynamic sidebar render complete!
```

**If you see errors:**

❌ `getAllowedMenus function not found`
→ Problem: Helper functions not loaded
→ Fix: Check `app.blade.php` has the script section

❌ `No admin auth data in localStorage`
→ Problem: Login not caching data
→ Fix: Logout, clear localStorage, login again

❌ `No menus available for this user`
→ Problem: No permissions in database
→ Fix: Run SQL file again

---

### Step 4: Force Fresh Login

1. **Clear LocalStorage:**
   - Browser DevTools → Application → Local Storage → Clear

2. **Logout:**
   ```
   http://your-site/admin/logout
   ```

3. **Clear Browser Cache:**
   - Ctrl+Shift+Delete → Clear cache

4. **Login Again**

5. **Check Console** immediately after login

---

### Step 5: Manual SQL Check

```sql
-- Check your admin's role
SELECT a.name, a.role_id, r.name as role_name, r.slug
FROM admins a
JOIN admin_roles r ON a.role_id = r.id
WHERE a.id = YOUR_ADMIN_ID;

-- Check permissions for your role
SELECT 
    m.name as menu_name,
    p.name as permission_name,
    rmp.allow
FROM admin_role_menu_permission rmp
JOIN admin_menu_permission mp ON rmp.menu_permission_id = mp.id
JOIN admin_menus m ON mp.menu_id = m.id
JOIN admin_permissions p ON mp.permission_id = p.id
WHERE rmp.role_id = YOUR_ROLE_ID
ORDER BY m.id, p.id;
```

---

## Common Issues & Solutions

### Issue 1: "Sidebar blank after dashboard"
**Cause:** JavaScript error stopping execution
**Fix:** Check browser console for errors

### Issue 2: "Old menus still showing"
**Cause:** Browser cache
**Fix:** Hard refresh (Ctrl+Shift+R) or clear cache

### Issue 3: "No permissions in session"
**Cause:** Role doesn't have admin assigned
**Fix:** 
```sql
UPDATE admins SET role_id = (SELECT id FROM admin_roles WHERE slug = 'super_admin') WHERE id = YOUR_ID;
```

### Issue 4: "Functions not found"
**Cause:** app.blade.php not loading properly
**Fix:** Check if `resources/views/admin/layouts/app.blade.php` has the helper script section

### Issue 5: "Menus render but permissions don't work"
**Cause:** Helper function logic issue
**Fix:** Check `hasPermission()` function in app.blade.php

---

## Quick Fixes

### Fix 1: Re-run Everything
```bash
# Clear everything and start fresh
mysql -u root -p your_database

# In MySQL:
TRUNCATE TABLE admin_role_menu_permission;
TRUNCATE TABLE admin_menu_permission;
TRUNCATE TABLE admin_menus;
TRUNCATE TABLE admin_permissions;

# Exit MySQL and run:
mysql -u root -p your_database < database/menu_permissions_data.sql
```

### Fix 2: Force Logout/Login
```bash
# Clear sessions in Laravel
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Then logout and login
```

### Fix 3: Check Composer Autoload
```bash
composer dump-autoload
```

---

## Still Not Working?

**Share these with me:**

1. Screenshot of `/admin/debug-permissions` page
2. Browser console output (all messages)
3. Result of this SQL:
   ```sql
   SELECT COUNT(*) FROM admin_menus;
   SELECT COUNT(*) FROM admin_role_menu_permission WHERE allow = 1;
   ```

---

## Expected Final Result

**Sidebar should look like:**

```
🏠 Dashboard

🛡️ Role & Permissions ▼
  ├─ Admin Roles
  ├─ Admin Permissions
  ├─ Menu Permissions
  ├─ Role Menu Permissions
  └─ Admin Menus

👤 Admin ▼
  └─ Admins

🚪 Logout
```

Click **Role & Permissions** → Children should expand
Click **Admin** → Children should expand

