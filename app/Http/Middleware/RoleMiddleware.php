<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $roleList = explode('|', strtolower($role));

        if (in_array(strtolower($request->user->role), $roleList)) {
            return $next($request);
        }

        return response()->json([
            'code' => 401,
            'message' => 'Unauthorized.',
            'data' => null
        ], 401);
    }
}
