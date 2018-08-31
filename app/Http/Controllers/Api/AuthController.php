<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\BadRequestException;
use App\Exceptions\Api\InternalErrorException;
use App\Exceptions\Api\UnauthorizedException;
use App\Logic\Authentication\AppAuth;
use App\Logic\Authentication\WeChatAuthAdapter;
use App\Models\User;
use Carbon\Carbon;
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
     *            ref="$/definitions/success",
     *             @SWG\Property(
     *                 property="data",
     *                 @SWG\Property(property="token", type="integer",example="token"),
     *                 @SWG\Property(property="expire_time", type="string",example="token有效时间，分钟"),
     *                 @SWG\Property(property="expire_at", type="string",example="token过期时间"),
     *             ),
     *         )
     *    )
     * )
     */
    public function weChatAccessToken()
    {
        $this->rule([
            'code' => 'required'
        ]);

        $credentials = ['code' => $this->query['code']];
        $authAdapter = new WeChatAuthAdapter();

        return $this->returnToken($authAdapter, $credentials);
    }

    /**
     * @SWG\Post(
     *    tags={"auth"},
     *    path="/auth/wechat/register",
     *    summary="小程序注册用户",
     *    description="小程序注册用户",
     *    @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="表单数据",
     *         required=true,
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="code", type="string",example="微信code"),
     *             @SWG\Property(property="mobile", type="string",example="手机号"),
     *             @SWG\Property(property="avatar", type="string",example="头像"),
     *             @SWG\Property(property="nickname", type="string",example="昵称"),
     *         )
     *     ),
     *    @SWG\Response(
     *        response=200,
     *        description="操作成功",
     *        @SWG\Schema(
     *            type="object",
     *            ref="$/definitions/success",
     *             @SWG\Property(
     *                 property="data",
     *                 @SWG\Property(property="token", type="integer",example="token"),
     *                 @SWG\Property(property="expire_time", type="string",example="token有效时间，分钟"),
     *                 @SWG\Property(property="expire_at", type="string",example="token过期时间"),
     *             ),
     *         )
     *    )
     * )
     */
    public function weChatRegister()
    {
        $this->rule([
            'code' => 'required',
            'mobile' => 'required|mobile'
        ]);

        $code = $this->getData('code');
        $mobile = $this->getData('mobile');
        $avatar = $this->getData('avatar');
        $nickname = $this->getData('nickname');

        $miniProgram = \EasyWeChat::miniProgram();
        $result = $miniProgram->auth->session($code);
        if (!$result) {
            throw InternalErrorException::instance('微信没有响应');
        }
        $openId = $result['openid'] ?? null;
        if (!$openId) {
            throw BadRequestException::instance('openid获取失败: ' . $result['errmsg']);
        }
        //是否已注册
        $user = User::where('mobile', $mobile)->first();
        if ($user) {
            throw BadRequestException::instance('手机号已被注册');
        }
        $user = User::where('wx_openid', $openId)->first();
        if ($user) {
            throw BadRequestException::instance('openid已被注册');
        }
        // 注册用户
        $user = User::newUserFromMobileAndOpenId($mobile, $openId);
        if ($avatar && $nickname) {
            $user->avatar = $avatar;
            $user->nickname = $nickname;
        }
        $user->saveOrError();

        return $this->responseToken(\Auth::tokenById($user->id));
    }

    private function returnToken($authAdapter, $credentials)
    {
        try {
            $token = (new AppAuth($authAdapter))->attempt($credentials);
            if (!$token) {
                throw UnauthorizedException::instance('获取token失败');
            }
            return $this->responseToken($token);
        } catch (JWTException $exception) {
            throw UnauthorizedException::instance($exception->getMessage());
        }
    }

    private function responseToken($token)
    {
        $expireTime = config('jwt.ttl');

        return response([
            'token' => $token,
            'expire_time' => $expireTime,
            'expire_at' => Carbon::now()->addMinutes($expireTime)->toDateTimeString(),
        ], 200, ['Token' => 'Bearer ' . $token]);
    }
}
