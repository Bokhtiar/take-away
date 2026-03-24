# 🎯 Collapsible Sidebar Implementation Guide

## ✅ Complete Feature Set

Your Laravel Blade admin dashboard now has a **fully collapsible sidebar** with state persistence!

---

## 🎨 Key Features

### 1. **Desktop Sidebar Collapse/Expand**
- **Expanded:** Full width (w-72/w-80) with icons + text labels
- **Collapsed:** Icon-only (w-20) with tooltips on hover
- **Smooth transition:** Width animates smoothly (300ms)
- **State persistence:** Saved in localStorage across sessions

### 2. **Mobile Sidebar Toggle**
- **Hidden by default** on mobile (<1024px)
- **Hamburger button** in header toggles slide-in/out
- **Overlay** appears when open
- **Auto-close** when clicking links or overlay

### 3. **Dual Toggle Buttons**
- **Header button:** Desktop collapse/expand (top-left)
- **Sidebar button:** Collapse/expand at bottom of sidebar
- **Both sync state:** Using Alpine.js reactivity

### 4. **Tooltips on Hover**
- When sidebar is collapsed, hovering shows tooltip with full menu name
- Dark theme tooltip (bg-gray-900)
- Smooth fade-in animation

### 5. **Permission-Based Menus**
- Uses existing `can()` helper
- Dynamic menu rendering from session/DB
- Nested menu support (parent/child)
- Active route highlighting

---

## 📂 Files Modified

```
resources/views/admin/layouts/
├── app.blade.php          ← Alpine.js state management (sidebarCollapsed)
├── header.blade.php       ← Added collapse button in header
├── sidebar.blade.php      ← Collapsible sidebar with tooltips
└── footer.blade.php       ← (No changes)
```

---

## 🔧 Technical Implementation

### **1. Alpine.js State Management**

```blade
<!-- app.blade.php -->
<div x-data="{ 
        sidebarOpen: false,              // Mobile toggle state
        sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',  // Desktop collapse state
        toggleCollapse() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('sidebarCollapsed', this.sidebarCollapsed);  // Persist state
        }
    }">
    <!-- Layout content -->
</div>
```

**State Variables:**
- `sidebarOpen`: Controls mobile slide-in/out (temporary)
- `sidebarCollapsed`: Controls desktop collapse/expand (persistent)

**Methods:**
- `toggleCollapse()`: Toggles collapsed state and saves to localStorage

---

### **2. Responsive Sidebar Width**

```blade
<!-- sidebar.blade.php -->
<aside :class="[
            sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
            sidebarCollapsed ? 'lg:w-20' : 'lg:w-72 xl:w-80'
        ]"
       class="transition-all duration-300 ease-in-out">
```

**Width States:**
| State | Mobile | Desktop (Expanded) | Desktop (Collapsed) |
|-------|--------|-------------------|---------------------|
| Width | `w-64` | `lg:w-72 xl:w-80` | `lg:w-20` |
| Text | ✅ Shown | ✅ Shown | ❌ Hidden (tooltip) |
| Icons | ✅ Shown | ✅ Shown | ✅ Shown |

---

### **3. Conditional Text Display**

```blade
<!-- Show text only when NOT collapsed (or on mobile) -->
<span x-show="!sidebarCollapsed || window.innerWidth < 1024" 
      x-transition:enter="transition-opacity duration-200"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      class="whitespace-nowrap">
    Dashboard
</span>
```

**Logic:**
- **Desktop Expanded:** Text visible
- **Desktop Collapsed:** Text hidden (fade-out animation)
- **Mobile:** Always visible (regardless of collapsed state)

---

### **4. Hover Tooltips**

```blade
<!-- Tooltip appears when sidebar is collapsed on desktop -->
<div x-show="sidebarCollapsed && window.innerWidth >= 1024" 
     class="absolute left-full ml-2 px-2 py-1 
            bg-gray-900 text-white text-xs rounded 
            opacity-0 group-hover:opacity-100 
            transition-opacity pointer-events-none 
            whitespace-nowrap z-50">
    Dashboard
</div>
```

**How it works:**
1. Hidden by default (`opacity-0`)
2. Parent has `group` class
3. On hover, `group-hover:opacity-100` makes it visible
4. Only shows when `sidebarCollapsed && desktop`

---

### **5. Toggle Buttons**

#### **Header Button (Desktop Only):**
```blade
<!-- header.blade.php -->
<button @click="toggleCollapse()" 
        class="hidden lg:inline-flex">
    <i :class="sidebarCollapsed ? 'ri-menu-unfold-line' : 'ri-menu-fold-line'"></i>
</button>
```

#### **Sidebar Button (Desktop Only):**
```blade
<!-- sidebar.blade.php -->
<button @click="toggleCollapse()">
    <i :class="sidebarCollapsed ? 'ri-menu-unfold-line' : 'ri-menu-fold-line'"></i>
    <span x-show="!sidebarCollapsed">Collapse Sidebar</span>
</button>
```

**Icons:**
- `ri-menu-fold-line`: When expanded (clicking will collapse)
- `ri-menu-unfold-line`: When collapsed (clicking will expand)

---

### **6. Dynamic Menu Rendering**

```javascript
// sidebar.blade.php - renderMenuItem()
function renderMenuItem(menu, level = 0) {
    // Parent menu with children
    html += `<button type="button" 
                :class="sidebarCollapsed ? 'lg:justify-center lg:px-2' : ''">
        <i class="${menu.menu_icon}" :class="sidebarCollapsed ? '' : 'lg:mr-3'"></i>
        <span x-show="!sidebarCollapsed || window.innerWidth < 1024">
            ${menu.menu_name}
        </span>
        <div x-show="sidebarCollapsed" class="tooltip">
            ${menu.menu_name}
        </div>
    </button>`;
    
    // Child links
    html += `<a href="${menu.menu_url}"
               :class="sidebarCollapsed ? 'lg:justify-center lg:px-2' : ''">
        <i class="${menu.menu_icon}"></i>
        <span x-show="!sidebarCollapsed">${menu.menu_name}</span>
        <div x-show="sidebarCollapsed" class="tooltip">
            ${menu.menu_name}
        </div>
    </a>`;
}
```

---

## 🎬 User Experience Flow

### **Desktop: Collapse/Expand**

```
User clicks collapse button (header or sidebar)
    ↓
Alpine.js: toggleCollapse() called
    ↓
sidebarCollapsed = !sidebarCollapsed
    ↓
localStorage.setItem('sidebarCollapsed', true/false)
    ↓
Sidebar width transitions: w-72 ↔ w-20 (300ms)
    ↓
Text labels fade out/in (200ms)
    ↓
Tooltips enabled/disabled
    ↓
✅ State saved for next visit
```

### **Desktop: Hover Tooltip**

```
User hovers over collapsed menu item
    ↓
CSS: group-hover:opacity-100
    ↓
Tooltip fades in (200ms)
    ↓
Shows full menu name
    ↓
✅ User can identify menu
```

### **Mobile: Slide Toggle**

```
User clicks hamburger button
    ↓
Alpine.js: sidebarOpen = true
    ↓
Sidebar: translate-x-0 (slides in)
    ↓
Overlay appears (bg-opacity-50)
    ↓
User clicks link or overlay
    ↓
sidebarOpen = false
    ↓
Sidebar: -translate-x-full (slides out)
    ↓
✅ Back to normal view
```

---

## 📱 Responsive Behavior

### **Mobile (<1024px):**
- ✅ Sidebar hidden by default
- ✅ Hamburger button shows in header
- ✅ Sidebar slides in/out (full width: w-64)
- ✅ Text always visible when open
- ✅ Overlay covers screen when open
- ❌ Collapse button not shown (not needed)

### **Desktop (≥1024px):**
- ✅ Sidebar visible by default
- ✅ Can be collapsed manually (w-72 → w-20)
- ✅ Collapse button in header + sidebar
- ✅ Tooltips on hover when collapsed
- ✅ State persists in localStorage
- ❌ Hamburger button hidden

---

## 🎨 Visual States

### **1. Expanded State (Desktop)**

```
┌─────────────────────────────┬──────────────────────┐
│ 🏠 Dashboard                 │ Main Content         │
│ 📁 Role & Permissions        │                      │
│    ├─ 👥 Admin Roles         │                      │
│    ├─ 🔑 Admin Permissions   │                      │
│ 📁 Admin                     │                      │
│    └─ 👤 Admins              │                      │
│                              │                      │
│ ◀ Collapse Sidebar          │                      │
│ 🚪 Logout                   │                      │
└─────────────────────────────┴──────────────────────┘
        Width: 288px (w-72)
```

### **2. Collapsed State (Desktop)**

```
┌───┬──────────────────────────────┐
│ 🏠 │ Main Content                 │
│ 📁 │                              │
│ 📁 │                              │
│   │                              │
│ ▶ │                              │
│ 🚪 │                              │
└───┴──────────────────────────────┘
  Width: 80px (w-20)
  
  (Hover over icon shows tooltip)
```

### **3. Mobile View**

```
Hidden by default           Opened (overlay)
                           ┌─────────────────────┐
                           │ BokhtiarPro      [X] │
                           ├─────────────────────┤
                           │ 🏠 Dashboard        │
                           │ 📁 Role & Perms     │
                           │    👥 Admin Roles   │
                           │ 📁 Admin            │
┌──────────────┐          │    👤 Admins        │
│ [☰] Page     │          │                     │
│              │   →      │ 🚪 Logout           │
│ Content      │          └─────────────────────┘
│              │          [Dark Overlay]
└──────────────┘
```

---

## 💾 State Persistence

### **localStorage Structure:**

```javascript
// When user collapses sidebar
localStorage.setItem('sidebarCollapsed', 'true');

// When user expands sidebar
localStorage.setItem('sidebarCollapsed', 'false');

// On page load
const collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
```

**Benefits:**
- ✅ State persists across page reloads
- ✅ State persists across browser tabs
- ✅ User preference remembered
- ✅ No server-side storage needed

---

## 🧪 Testing Checklist

### **Desktop Tests:**

- [ ] Click collapse button in header → sidebar collapses
- [ ] Click expand button in sidebar → sidebar expands
- [ ] Width transitions smoothly (300ms)
- [ ] Text fades in/out smoothly (200ms)
- [ ] Tooltips appear on hover when collapsed
- [ ] State persists after page reload
- [ ] Active menu item highlighted correctly
- [ ] Nested menus work properly

### **Mobile Tests:**

- [ ] Sidebar hidden by default
- [ ] Hamburger button visible
- [ ] Click hamburger → sidebar slides in
- [ ] Overlay appears
- [ ] Click overlay → sidebar closes
- [ ] Click menu link → sidebar closes
- [ ] Text always visible on mobile
- [ ] No collapse button shown on mobile

### **Responsive Tests:**

- [ ] Resize from desktop to mobile → sidebar auto-hides
- [ ] Resize from mobile to desktop → sidebar shows
- [ ] Collapsed state maintained during resize
- [ ] All breakpoints work correctly

### **Permission Tests:**

- [ ] Only allowed menus shown
- [ ] Action buttons hidden if no permission
- [ ] Dynamic menus render correctly
- [ ] Nested permissions work

---

## 🎯 CSS Classes Breakdown

### **Sidebar Width Classes:**

```html
<!-- Base -->
class="w-64"                    → 256px (mobile fixed)

<!-- Desktop Dynamic -->
:class="sidebarCollapsed ? 'lg:w-20' : 'lg:w-72 xl:w-80'"
    lg:w-20    → 80px (collapsed)
    lg:w-72    → 288px (expanded)
    xl:w-80    → 320px (expanded, extra-large screens)
```

### **Transition Classes:**

```html
<!-- Width & Transform Transition -->
class="transition-all duration-300 ease-in-out"
    transition-all  → Animate all properties (width, transform, etc.)
    duration-300    → 300ms animation
    ease-in-out     → Smooth acceleration/deceleration

<!-- Opacity Transition (for text fade) -->
x-transition:enter="transition-opacity duration-200"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
```

### **Conditional Classes:**

```html
<!-- Collapsed State -->
:class="sidebarCollapsed ? 'lg:justify-center lg:px-2' : ''"
    lg:justify-center  → Center icon when collapsed
    lg:px-2           → Reduced padding when collapsed

<!-- Icon Margin -->
:class="sidebarCollapsed ? '' : 'lg:mr-3'"
    lg:mr-3  → Add margin-right when expanded (spacing between icon & text)
    ''       → No margin when collapsed (icon only)
```

### **Tooltip Classes:**

```html
class="absolute left-full ml-2 px-2 py-1 
       bg-gray-900 text-white text-xs rounded 
       opacity-0 group-hover:opacity-100 
       transition-opacity pointer-events-none 
       whitespace-nowrap z-50"

absolute left-full ml-2     → Position to the right of parent
bg-gray-900 text-white      → Dark theme
opacity-0                   → Hidden by default
group-hover:opacity-100     → Show on parent hover
pointer-events-none         → Don't block clicks
whitespace-nowrap           → Keep text on one line
z-50                        → Above other content
```

---

## 🚀 Usage Examples

### **Example 1: Basic Page**

```blade
@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('admin-content')
<div class="space-y-6">
    <!-- Your content -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold">Welcome!</h2>
        <p>Sidebar automatically adjusts content width.</p>
    </div>
</div>
@endsection
```

**Result:**
- Sidebar collapsed → More content width
- Sidebar expanded → Normal content width
- Smooth transition between states

---

### **Example 2: Permission-Based Content**

```blade
@extends('admin.layouts.app')

@section('admin-content')
<div class="space-y-6">
    <!-- Only show if user has permission -->
    @can('admins.create')
        <div class="bg-white rounded-lg shadow p-6">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Add New Admin
            </button>
        </div>
    @endcan
    
    <!-- Table with permission-based actions -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td class="text-right space-x-2">
                        @can('admins.view')
                            <button class="text-blue-600">View</button>
                        @endcan
                        
                        @can('admins.edit')
                            <button class="text-yellow-600">Edit</button>
                        @endcan
                        
                        @can('admins.delete')
                            <button class="text-red-600">Delete</button>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
```

---

## 🐛 Troubleshooting

### **Issue: Sidebar not collapsing**

**Solution:** Check Alpine.js is loaded:
```html
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
```

### **Issue: State not persisting**

**Solution:** Check localStorage in browser console:
```javascript
console.log(localStorage.getItem('sidebarCollapsed'));
```

### **Issue: Tooltips not showing**

**Solution:** Ensure parent has `group` class and `relative` positioning:
```html
<a class="group relative">
    <i class="icon"></i>
    <div class="tooltip opacity-0 group-hover:opacity-100">Text</div>
</a>
```

### **Issue: Text not hiding on collapse**

**Solution:** Check Alpine.js expression:
```html
<span x-show="!sidebarCollapsed || window.innerWidth < 1024">
```

### **Issue: Width transition jerky**

**Solution:** Ensure transition class:
```html
class="transition-all duration-300 ease-in-out"
```

---

## 📊 Performance Considerations

### **localStorage vs Session:**

| Storage | Read Speed | Persistence | Security |
|---------|-----------|-------------|----------|
| **localStorage** | ⚡ Instant | ✅ Permanent | ⚠️ Client-side |
| **Session** | 🐢 Server request | ❌ Expires | ✅ Server-side |

**For sidebar collapse state:**
- ✅ Use localStorage (UI preference, not sensitive)
- ⚡ No server roundtrip needed
- 💾 Persists across sessions

**For permissions:**
- ✅ Use Session (security-critical)
- 🔒 Server-side validation
- ❌ Never in localStorage

---

## ✨ Advanced Customization

### **1. Change Collapsed Width:**

```blade
<!-- sidebar.blade.php -->
:class="sidebarCollapsed ? 'lg:w-16' : 'lg:w-80'"
<!--                         ↑ narrower   ↑ wider -->
```

### **2. Change Animation Speed:**

```html
class="transition-all duration-500"  <!-- Slower (500ms) -->
class="transition-all duration-150"  <!-- Faster (150ms) -->
```

### **3. Different Tooltip Style:**

```html
<div class="bg-blue-600 text-white">  <!-- Blue theme -->
<div class="bg-black text-white">     <!-- Black theme -->
<div class="bg-white text-gray-900 border">  <!-- Light theme -->
```

### **4. Auto-collapse on Mobile Portrait:**

```javascript
window.addEventListener('resize', () => {
    if (window.innerWidth < 768 && window.innerHeight > window.innerWidth) {
        // Portrait mode - auto collapse
        localStorage.setItem('sidebarCollapsed', 'true');
    }
});
```

---

## 📝 Summary

✅ **Desktop:** Manual collapse/expand with state persistence  
✅ **Mobile:** Slide-in/out with hamburger toggle  
✅ **Tooltips:** Hover to see full names when collapsed  
✅ **Smooth animations:** Width & opacity transitions  
✅ **Permission-based:** Dynamic menu rendering  
✅ **Active highlighting:** Current route marked  
✅ **Nested menus:** Parent/child accordion support  
✅ **Production-ready:** Optimized & accessible  

---

## 🎉 Ready to Use!

তোমার **collapsible sidebar** এখন production-ready! 

**Features:**
- 🖥️ Desktop: Collapse করে icon-only view
- 📱 Mobile: Hamburger দিয়ে toggle
- 💾 State persist করে localStorage এ
- 🎨 Smooth animations সব জায়গায়
- 🔒 Permission-based menus working
- ⚡ Fast & optimized

Test করো এবং enjoy করো! 🚀

