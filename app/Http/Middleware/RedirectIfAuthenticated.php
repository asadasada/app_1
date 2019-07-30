<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    //"guest"ミドルウェアはここ
    public function handle($request, Closure $next, $guard = null)
    {
        //ログインしてるかチェック
        if (Auth::guard($guard)->check()) {
            return redirect('/');
        }
        //adminか確認するならAuth::user()などを使おう

        return $next($request);
    }
}
