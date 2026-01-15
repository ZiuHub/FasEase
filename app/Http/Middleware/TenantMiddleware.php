<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $organization = $request->route('organization');
        if(!$organization || !$organization->is_active) {
            abort(404, 'Organization not found or inactive.');
        }
        // simpan organisasi/tenant yg aktif ke global
        app()->instance('currentOrganization', $organization);
        return $next($request);
    }
}
