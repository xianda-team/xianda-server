<?php namespace App\Logic\Authentication;

use App\Models\User;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * 微信登录授权认证
 * Class WeChatAuthAdapter
 * @package App\Logic\Authentication
 */
class WeChatAuthAdapter implements Auth
{
    protected $user;

    public function byCredentials(array $credentials = [])
    {
        $code = $credentials['code'] ?? '';
        $miniProgram = \EasyWeChat::miniProgram();
        $result = $miniProgram->auth->session($code);
        if (!$result) {
            throw new JWTException('获取openid失败, 微信没有响应');
        }
        $openId = $result['openid'] ?? null;
        if (!$openId) {
            throw new JWTException('获取openid失败, ' . $result['errmsg'] ?? 0);
        }
        $unionid = $result['unionid'] ?? $openId;

        $user = User::where('wx_openid', $openId)->where('wx_unionid', $unionid)->first();
        if (!$user) {
            $user = User::newUserFromWxId($openId, $unionid);
        }
        $this->user = $user;
        return true;
    }

    public function byId($id)
    {
        $this->user = User::find($id);
        return $this->user;
    }

    public function user()
    {
        return $this->user;
    }
}