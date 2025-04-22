<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Auth;
class CheckApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $token = $request->bearerToken();

        $apiKey = ApiKey::where('is_expired', 0)
        ->where('api_key', $token)
        ->first();

        if(!$apiKey) {
            return response()->json(['status'=>false, 'message' => 'Unauthorized'], 401);
        }

        $request->session()->put('userId', $apiKey->user_id);

        return $next($request);
    }
}
