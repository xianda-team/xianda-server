<?php namespace App\Logic\Authentication;

use App\User;
use Tymon\JWTAuth\Contracts\Providers\Auth;

/**
 * 微信登录授权认证
 * Class WeChatAuthAdapter
 * @package App\Logic\Authentication
 */
class WeChatAuthAdapter implements Auth
{
    public function byCredentials(array $credentials = [])
    {
        return true;
    }

    public function byId($id)
    {
        $user = new User();
        $user->id = 1;
        return $user;
    }

    public function user()
    {
        $user = new User();
        $user->id = 1;
        return $user;
    }
}