<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    // Permite el paso solo a usuarios activos con uno de los roles indicados
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || $user->status !== 'active' || ! $user->hasRole($roles)) {
            abort(403, 'This action is unauthorized.');
        }

        return $next($request);
    }
}
