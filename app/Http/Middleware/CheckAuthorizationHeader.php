<?php

namespace App\Http\Middleware;

use App\Exceptions\Api\TokenMismatchException;
use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class CheckAuthorizationHeader extends BaseMiddleware
{

    public function handle($request, Closure $next, $guard = null)
    {
        try {
            \JWTAuth::parseToken();
        } catch (JWTException $exception) {
            throw new TokenMismatchException($exception->getMessage());
        }

        return $next($request);
    }
}
