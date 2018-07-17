<?php namespace App\Exceptions\Api;


class UnauthorizedException extends ApiException
{
    protected $code = 401;
    protected $message = 'Bad credentials';

    public function getStatusCode()
    {
        return 401;
    }
}
