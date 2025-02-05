<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class GuestUserRejectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ゲストユーザーの場合前の画面に戻る
        if (Auth::user()->id === 1 || Auth::user()->id === 2 || Auth::user()->id === 3) {
            return Redirect::back()->with('flash-message-error', 'ゲストユーザーでログインしている場合、本操作は利用を制限しております');
        }

        return $next($request);
    }
}
