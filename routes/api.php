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
    $api->get('system/config', 'App\Http\Controllers\Api\SystemController@config');

    $api->group(['middleware' => ['auth:api']], function ($api) {
        $api->get('users/{id}', 'App\Http\Controllers\Api\UserController@show');

        $api->post('clothing', 'App\Http\Controllers\Api\ClothingController@store');
        $api->put('clothing/{id}', 'App\Http\Controllers\Api\ClothingController@update');
        $api->delete('clothing/{id}', 'App\Http\Controllers\Api\ClothingController@delete');
        $api->get('clothing', 'App\Http\Controllers\Api\ClothingController@index');
        $api->get('clothing/{id}', 'App\Http\Controllers\Api\ClothingController@show');
        $api->post('clothing-wear/{id}', 'App\Http\Controllers\Api\ClothingController@addToWear');
        $api->delete('clothing-wear/{id}/{wearId}', 'App\Http\Controllers\Api\ClothingController@removeFromWear');

        $api->post('wear', 'App\Http\Controllers\Api\WearController@store');
        $api->put('wear/{id}', 'App\Http\Controllers\Api\WearController@update');
        $api->delete('wear/{id}', 'App\Http\Controllers\Api\WearController@delete');
        $api->get('wear', 'App\Http\Controllers\Api\WearController@index');
        $api->get('wear/{id}', 'App\Http\Controllers\Api\WearController@show');
        $api->post('wear-clothing/{id}', 'App\Http\Controllers\Api\WearController@addClothing');

        $api->get('file/token/{bucket}', 'App\Http\Controllers\Api\FileController@getUploadFileToken');
    });
});


