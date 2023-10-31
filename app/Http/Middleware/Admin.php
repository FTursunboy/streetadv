<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if ($user->roleID == 55) {
            Auth::logout();
            abort(404);
        }

        return $next($request);
    }
}
