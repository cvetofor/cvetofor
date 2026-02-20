<?php
// app/Http/Middleware/SaveUtm.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SaveUtm
{
    public function handle(Request $request, Closure $next)
    {
        foreach (['utm_source', 'utm_medium', 'utm_campaign'] as $utm) {
            if ($request->has($utm)) {
                session([$utm => $request->query($utm)]);
            }
        }

        return $next($request);
    }
}
