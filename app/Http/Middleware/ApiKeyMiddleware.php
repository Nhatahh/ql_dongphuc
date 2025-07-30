<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('Authorization');

        if ($apiKey != 'Bearer ' . env('API_KEY')) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized: Invalid API Key'], 401);
        }

        return $next($request);
    }

}
