<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $api->get('auth/wechat/access-token', 'App\Http\Controllers\Api\AuthController@weChatAccessToken');

    $api->group(['middleware' => ['auth:api']], function ($api) {
        $api->get('users/{id}', 'App\Http\Controllers\Api\UserController@show');
    });
});


