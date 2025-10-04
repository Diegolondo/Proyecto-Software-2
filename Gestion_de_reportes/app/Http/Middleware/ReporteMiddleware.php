<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReporteMiddleware
{
  public function handle(Request $request, Closure $next): Response
    {   
        $ApiKeyReceived = $request->header("X-API-key");
        $ApiKey = env("API_KEY");
        if ($ApiKeyReceived !== $ApiKey ){
            return response()->json(["message"=>"Acceso Denegado"], 403);
        }
        return $next($request);
    }
}
