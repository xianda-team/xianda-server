<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;


/**
 * @SWG\Swagger(
 *     basePath="/api",
 *     @SWG\Info(
 *         title="鲜搭API文档",
 *         version="1.0.0",
 *         description="
 *         ## 公共响应码
 *         200 ok: 服务器成功返回用户请求的数据;
 *         401 Unauthorized：表示用户没有权限（token无效或已过期）
 *         404 Not Found: 请求地址不存在
 *         429 Too Many Requests：请勿频繁请求
 *         500 INTERNAL SERVER ERROR：服务器发生错误"
 *     ),
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\SecurityScheme(
 *        securityDefinition="need_login",
 *        type="apiKey",
 *        in="header",
 *        name="Authorization",
 *        description="登录接口",
 *    ),
 *    @SWG\Response(
 *         response="Success",
 *         description="操作成功"
 *     ),
 *     @SWG\Tag(name="auth", description="身份认证"),
 *     @SWG\Tag(name="user", description="用户"),
 *     @SWG\Tag(name="wear", description="搭配"),
 *     @SWG\Tag(name="clothing", description="单品"),
 *     @SWG\Tag(name="system", description="系统"),
 * )
 */
class BaseController extends Controller
{
    use Helpers;
}