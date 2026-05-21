<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $role = Auth::user()->role->role_name;

        // Check if user is an Employee or Admin
        if ($role === 'Employee' || $role === 'Admin') {
            return $next($request);
        }

        // If they are a student, kick them back to the catalog
        return redirect()->route('catalog.index')->with('error', 'Unauthorized Access.');
    }
}
