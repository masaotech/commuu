<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    /**
     * ルートURL リクエスト
     */
    public function rootUrl(): RedirectResponse
    {
        if (Auth::check()) {
            return Redirect::route('shoppingitem.index');
        } else {
            return Redirect::route('login');
        }
    }
}
