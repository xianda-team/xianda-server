<?php

namespace App\Exceptions\Api;

class BadRequestException extends ApiException
{
    protected $code = 400;
    protected $message = 'Bad Request';

    public function getStatusCode()
    {
        return 400;
    }
}