<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// If Laravel >= 5.2 then delete 'use' and 'implements' of deprecated Middleware interface.
class AddHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->header('Cache-Control', 'no-cache, no-store');
        $response->header('Neutron-Star', 'whoosh');

        return $response;
    }

}
