<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOperator
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isOperator()) {
            abort(403);
        }

        return $next($request);
    }
}
