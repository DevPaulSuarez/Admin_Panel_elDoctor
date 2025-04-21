<?php

namespace App\Http\Middleware;

use Closure;

class SkipAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        // Simular un usuario autenticado
        if (!session()->has('current_user')) {
            session(['current_user' => [
                'id' => 1,
                'nombre' => 'Admin',
                'email' => 'admin@example.com',
                'rol' => 'admin'
            ]]);
        }

        return $next($request);
    }
} 