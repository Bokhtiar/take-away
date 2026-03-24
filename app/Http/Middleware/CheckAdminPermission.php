<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    public function handle(Request $request, Closure $next, string $menuSlug): Response
    {
        if (!session('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Please login first');
        }

        // Get Laravel controller action method name
        $action = $request->route()->getActionMethod();

        /**
         * Map Laravel method names to permission slugs
         * 
         * Why needed?
         * - Laravel uses: store(), update(), destroy() (technical names)
         * - DB has: create, edit, delete (user-friendly names)
         * 
         * Only Laravel standard methods need mapping.
         * Custom methods (updateBulk, assign, etc.) match directly with DB permissions.
         */
        $actionMap = [
            'index' => 'access',       // GET list page -> access permission
            'assign' => 'access',      // Custom role assignment page -> access permission
            'show' => 'view',          // GET single record page -> view permission
            'store' => 'create',      // POST request → create permission
            'update' => 'edit',       // PUT request → edit permission
            'updateBulk' => 'edit',   // Custom bulk update -> edit permission
            'destroy' => 'delete',    // DELETE request → delete permission
        ];

        // Convert action to permission slug
        $permission = $actionMap[$action] ?? $action;

        // Check if user has permission (from session)
        if (!can("{$menuSlug}.{$permission}")) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}

