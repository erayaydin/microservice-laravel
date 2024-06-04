<?php

namespace MService\License\Middlewares;

use Closure;
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

        $pKey = file_get_contents("/tmp/secrets/oauth-public.key");
        $decoded = JWT::decode($jwt, new Key($pKey, 'RS256'));

        $request->merge(['user_id' => $decoded->sub]);

        return $next($request);
    }
}
