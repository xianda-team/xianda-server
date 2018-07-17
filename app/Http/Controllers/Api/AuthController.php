<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\UnauthorizedException;
use App\Logic\Authentication\AppAuth;
use App\Logic\Authentication\WeChatAuthAdapter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends BaseController
{

    public function weChatAccessToken(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $authAdapter = new WeChatAuthAdapter();

        return $this->returnToken($authAdapter, $credentials);
    }


    private function returnToken($authAdapter, $credentials)
    {
        try {
            $token = (new AppAuth($authAdapter))->attempt($credentials);
            if (!$token) {
                throw UnauthorizedException::instance('获取token失败');
            }
            $expireTime = config('jwt.refresh_ttl');
            return [
                'token' => $token,
                'expire_time' => $expireTime,
                'expire_at' => Carbon::now()->addMinutes($expireTime)->toDateTimeString(),
            ];

        } catch (JWTException $exception) {
            throw UnauthorizedException::instance($exception->getMessage());
        }
    }
}
