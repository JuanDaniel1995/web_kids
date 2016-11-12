<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Access\AuthorizationException;
use App\Constants;
use App\User;
use Closure;
use Auth;
use Lang;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userRole = User::find(Auth::user()->id)->role;
        if ($userRole === Constants::ADMIN_ROLE) return $next($request);
        if ($request->ajax()) return response()->json(Lang::get('main.permissions'), 404);
        throw new AuthorizationException();
    }
}
