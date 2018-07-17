<?php

namespace App\Exceptions\Api;

class InternalErrorException extends ApiException
{
    protected $code = 500;
    protected $message = 'Internal Server Error';

}