<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class PlayerAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // ログインしていない場合はログイン画面へ遷移
    // protected function redirectTo(Request $request)
    // {
    //     return route('login.index');
    // }
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('player.login.index');
    }
}
