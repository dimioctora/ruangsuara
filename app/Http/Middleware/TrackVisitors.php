<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Track unique IP visitors
        $ip = $request->ip();
        
        // Use cache to prevent redundant DB writes for the same IP (1 hour expiry)
        \Illuminate\Support\Facades\Cache::remember('v_'.$ip, 3600, function() use ($ip) {
            \Illuminate\Support\Facades\DB::table('visitors')->insertOrIgnore([
                'ip_address' => $ip,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return true;
        });

        return $next($request);
    }
}
