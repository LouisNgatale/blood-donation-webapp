<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $collection = DB::table('users')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('users.id', '=', \auth()->id())
            ->select('roles.role')
            ->get();

        $json_decode = json_decode($collection, true);

        if ($json_decode[0]['role'] == "DONOR") {
            return $next($request);
        }
        abort(403);
    }
}
