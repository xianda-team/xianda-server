<?php namespace App\Logic\Authentication;


use Tymon\JWTAuth\Contracts\Providers\Auth;

class AppAuth
{

    /**
     * @var AuthInterface
     */
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function attempt(array $credentials = [])
    {
        if (!$this->auth->byCredentials($credentials)) {
            return false;
        }

        return \JWTAuth::fromUser($this->auth->user());
    }
}