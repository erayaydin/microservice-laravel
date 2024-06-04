<?php

namespace MService\License\Middlewares;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jwt = $request->bearerToken();

        if (is_null($jwt)) {
            return response(status: 403);
        }

        $pKey = file_get_contents("/tmp/secrets/oauth-public.key");

        try {
            $decoded = JWT::decode($jwt, new Key($pKey, 'RS256'));
        } catch (Exception) {
            return response(status: 403);
        }

        $request->merge(['user_id' => $decoded->sub]);

        return $next($request);
    }
}
