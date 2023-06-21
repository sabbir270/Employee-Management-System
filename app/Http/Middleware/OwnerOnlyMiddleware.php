<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OwnerOnlyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user is an "owner"
        if (auth()->check() && auth()->user()->user_type === 'owner') {
            return $next($request);
        }

        // If the user is not an "owner", redirect them or show an error message
        return redirect('/')->with('error', 'Unauthorized access');
    }

}
