<?php

namespace App\Http\Controllers\Api;


use Dingo\Api\Auth\Auth;

class UserController extends BaseController
{

    public function show($id)
    {
        return \Auth::user();
    }
}
