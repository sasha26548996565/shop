<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CanResetProjectMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->isAdmin())
        {
            return $next($request);
        }

        return abort(404);
    }
}
