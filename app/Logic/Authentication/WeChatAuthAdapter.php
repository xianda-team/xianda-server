<?php namespace App\Logic\Authentication;

use App\User;
use Tymon\JWTAuth\Providers\Auth\AuthInterface;

/**
 * 微信登录授权认证
 * Class WeChatAuthAdapter
 * @package App\Logic\Authentication
 */
class WeChatAuthAdapter implements AuthInterface
{
    public function byCredentials(array $credentials = [])
    {
        return false;
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