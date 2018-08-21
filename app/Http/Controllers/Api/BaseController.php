<?php

namespace App\Http\Controllers\Api;


use App\Exceptions\Api\ValidationException;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;


class BaseController extends Controller
{
    use Helpers;

    protected $query = [];

    protected $data = [];

    public function __construct()
    {
        $this->query = request()->query();
        $this->data = request()->json()->all();
    }


    protected function getQuery($key, $default = null)
    {
        $value = $this->query[$key] ?? $default;
        return is_string($value) ? trim($value) : $value;
    }

    protected function getData($key, $default = null)
    {
        $value = $this->data[$key] ?? $default;
        return is_string($value) ? trim($value) : $value;
    }

    protected function rule(array $rules, $customAttributes = [])
    {
        $validator = \Validator::make(array_merge($this->query, $this->data), $rules, [], $customAttributes);

        if (!$validator->passes()) {
            throw ValidationException::instance()->setErrors($validator->messages());
        }
    }
}