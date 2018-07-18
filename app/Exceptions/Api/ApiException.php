<?php

namespace App\Exceptions\Api;

use Dingo\Api\Contract\Debug\MessageBagErrors;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiException extends \Exception implements HttpExceptionInterface, MessageBagErrors
{
    protected $code = 500;
    protected $errors = [];

    // http status code
    public function getStatusCode()
    {
        return 500;
    }

    public function getHeaders()
    {
        return [];
    }

    public function hasErrors()
    {
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors($errors)
    {
        $this->errors = is_array($errors) ? new MessageBag($errors) : $errors;
        return $this;
    }

    public static function instance($messages, $code = null)
    {
        return new static($messages, $code);
    }
}