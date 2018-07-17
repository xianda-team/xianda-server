<?php
/**
 * Created by PhpStorm.
 * User: wanglei
 * Date: 18/7/17
 * Time: 下午2:17
 */

namespace App\Exceptions\Api;


class TokenMismatchException extends ApiException
{
    protected $code = 401;

    public function getStatusCode()
    {
        return 401;
    }
}