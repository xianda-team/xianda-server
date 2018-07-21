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
 *         401 Unauthorized：表示用户没有权限（令牌、用户名、密码错误）
 *         403 Forbidden: 表示用户得到授权，但是访问是被禁止的
 *         429 Too Many Requests：请勿频繁请求
 *         500 INTERNAL SERVER ERROR：服务器发生错误
 *         ...
 *
 *         ## 公共参数组成一个json字符串，放到 header 里，字段为：X-Device-Info
 *         ## 公共参数如下： "
 *     ),
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Response(
 *         response="Success",
 *         description="操作成功"
 *     ),
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