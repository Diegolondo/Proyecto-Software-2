<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return response()->json(["message"=>$request->all()]);
        if ($request->expectsJson()) {
            return null;
        }

        abort(response()->json([
            'message' => 'No autenticado'
        ], 401));
    }
}

