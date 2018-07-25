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

    /**
     * @SWG\Get(
     *    tags={"auth"},
     *    path="/auth/wechat/access-token",
     *    summary="获取 access token",
     *    description="获取 access token，之后的请求过程中，需要用户登录的接口需要带此 token 的 HTTP 头。
     *   注意这里使用的是 Bearer Token ，也就是说在 Authorization header 值的会以 Bearer + 空格 开头",
     *    @SWG\Parameter(
     *        name="code",
     *        in="query",
     *        description="微信code",
     *        required=true,
     *        type="string"
     *    ),
     *    @SWG\Response(
     *        response=200,
     *        description="操作成功",
     *        @SWG\Schema(
     *            type="object",
     *            @SWG\Property(property="token", type="integer",example="token"),
     *            @SWG\Property(property="expire_time", type="string",example="token有效时间，分钟"),
     *            @SWG\Property(property="expire_at", type="string",example="token过期时间"),
     *        )
     *    )
     * )
     */
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

            return response([
                'token' => $token,
                'expire_time' => $expireTime,
                'expire_at' => Carbon::now()->addMinutes($expireTime)->toDateTimeString(),
            ], 200, ['Token' => 'Bearer ' . $token]);

        } catch (JWTException $exception) {
            throw UnauthorizedException::instance($exception->getMessage());
        }
    }
}
