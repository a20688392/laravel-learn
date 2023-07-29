<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Symfony\Component\HttpFoundation\Response;

class JwtVerifiedMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // 驗證 JWT
            $user = auth('api')->user();
            if (!$user) {
                throw new JWTException();
            }
        } catch (TokenExpiredException $e) {
            $httpStatus = Response::HTTP_UNAUTHORIZED;
            $response = [
                "statusCode" => $httpStatus,
                "error" => 'token_expired'
            ];
            return response()->json($response, $httpStatus);
        } catch (TokenInvalidException $e) {
            $httpStatus = Response::HTTP_UNAUTHORIZED;
            $response = [
                "statusCode" => $httpStatus,
                'error' => 'token_invalid'
            ];
            return response()->json($response, $httpStatus);
        } catch (JWTException $e) {
            $httpStatus = Response::HTTP_UNAUTHORIZED;
            $response = [
                "statusCode" => $httpStatus,
                'error' => 'Unauthorized'
            ];
            return response()->json($response, $httpStatus);
        }
        return $next($request);
    }
}
