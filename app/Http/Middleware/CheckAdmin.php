<?php

namespace App\Http\Middleware;

use App\Constants\StatusCode as StatusCodeAlias;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check() || !Auth::user()->isAdmin()){
            return response()->json(['message'=>'Access denied. Admins only.'], StatusCodeAlias::FORBIDDEN);
        }
        return $next($request);
    }
}
