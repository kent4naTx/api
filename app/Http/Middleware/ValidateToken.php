<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->header('Authorization')) {

            return response()->json([
                "status" => false,
                "mensagem" => "tokenNotInformed",
            ], 401);
        } else if (strlen($request->header("Authorization")) != 48) {

            return response()->json([
                "status" => false,
                "mensagem" => "tokenInvalid",
            ], 401);
        }

        return $next($request);
    }
}
