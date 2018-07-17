<?php
/**
 * Created by PhpStorm.
 * User: wanglei
 * Date: 18/7/17
 * Time: 下午2:59
 */

namespace App\Exceptions\Api;


class ValidationException extends ApiException
{
    protected $code = 422;
    protected $message = '数据校验失败，请检查提交的数据';

    public function getStatusCode()
    {
        return 200;
    }
}