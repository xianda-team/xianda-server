<?php namespace App\Logic\Authentication;


use Tymon\JWTAuth\Providers\Auth\AuthInterface;

class AppAuth
{

    /**
     * @var AuthInterface
     */
    private $auth;

    public function __construct(AuthInterface $auth)
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