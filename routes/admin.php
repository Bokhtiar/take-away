<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/** authentication */
Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('login', [AuthController::class, 'login'])->name('admin.login');
Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

/** dashboard */
Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

/** debug permissions */
Route::get('debug-permissions', function() {
    return [
        'admin_id' => session('admin_id'),
        'admin_permissions' => session('admin_permissions'),
        'tests' => [
            'admin-roles.sidebar-menu' => can('admin-roles.sidebar-menu'),
            'admins.create' => can('admins.create'),
            'admins.view' => can('admins.view'),
        ]
    ];
})->name('admin.debug-permissions');

/** admin roles */
Route::resource('admin-roles', \App\Http\Controllers\Admin\AdminRoleController::class)
    ->names('admin.admin-roles')
    ->middleware('admin.check.permission:admin-roles');

/** admin permissions */
Route::resource('admin-permissions', \App\Http\Controllers\Admin\AdminPermissionController::class)
    ->names('admin.admin-permissions')
    ->middleware('admin.check.permission:admin-permissions');

/** admin menu permissions */
Route::put('admin-menu-permissions/update-bulk', [\App\Http\Controllers\Admin\AdminMenuPermissionController::class, 'updateBulk'])
    ->name('admin.admin-menu-permissions.update-bulk')
    ->middleware('admin.check.permission:menu-permissions');
    
Route::resource('admin-menu-permissions', \App\Http\Controllers\Admin\AdminMenuPermissionController::class)
    ->names('admin.admin-menu-permissions')
    ->middleware('admin.check.permission:menu-permissions');

/** admin role menu permissions */
Route::put('admin-role-menu-permissions/update-bulk', [\App\Http\Controllers\Admin\AdminRoleMenuPermissionController::class, 'updateBulk'])
    ->name('admin.admin-role-menu-permissions.update-bulk')
    ->middleware('admin.check.permission:role-menu-permissions');
    
Route::get('admin-role-menu-permissions/assign/{roleId?}', [\App\Http\Controllers\Admin\AdminRoleMenuPermissionController::class, 'assign'])
    ->name('admin.admin-role-menu-permissions.assign')
    ->middleware('admin.check.permission:role-menu-permissions');
    
Route::resource('admin-role-menu-permissions', \App\Http\Controllers\Admin\AdminRoleMenuPermissionController::class)
    ->names('admin.admin-role-menu-permissions')
    ->middleware('admin.check.permission:role-menu-permissions');

/** admin menus */
Route::resource('admin-menus', \App\Http\Controllers\Admin\AdminMenuController::class)
    ->names('admin.admin-menus')
    ->middleware('admin.check.permission:admin-menus');

/** admins */
Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class)
    ->names('admin.admins')
    ->middleware('admin.check.permission:admins');

/** categories */
Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)
    ->names('admin.categories')
    ->middleware('admin.check.permission:categories');

/** products */
Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)
    ->names('admin.products')
    ->middleware('admin.check.permission:products');

/** ingredients */
Route::resource('ingredients', \App\Http\Controllers\Admin\IngredientController::class)
    ->names('admin.ingredients')
    ->middleware('admin.check.permission:ingredients');

/** chefs */
Route::resource('chefs', \App\Http\Controllers\Admin\ChefController::class)
    ->names('admin.chefs')
    ->middleware('admin.check.permission:chefs');

/** product ingredients (one page) */
Route::get('product-ingredients', [\App\Http\Controllers\Admin\ProductIngredientController::class, 'index'])
    ->name('admin.product-ingredients.index')
    ->middleware('admin.check.permission:product-ingredients');
Route::post('product-ingredients', [\App\Http\Controllers\Admin\ProductIngredientController::class, 'store'])
    ->name('admin.product-ingredients.store')
    ->middleware('admin.check.permission:product-ingredients');

/** addons */
Route::resource('addons', \App\Http\Controllers\Admin\AddonController::class)
    ->names('admin.addons')
    ->middleware('admin.check.permission:addons');

/** product addons (one page) */
Route::get('product-addons', [\App\Http\Controllers\Admin\ProductAddonController::class, 'index'])
    ->name('admin.product-addons.index')
    ->middleware('admin.check.permission:product-addons');
Route::post('product-addons', [\App\Http\Controllers\Admin\ProductAddonController::class, 'store'])
    ->name('admin.product-addons.store')
    ->middleware('admin.check.permission:product-addons');

/** orders */
Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)
    ->only(['index', 'show', 'update', 'destroy'])
    ->names('admin.orders')
    ->middleware('admin.check.permission:orders');

