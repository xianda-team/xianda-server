<?php

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
 *     @SWG\Tag(name="auth", description="身份认证"),
 *     @SWG\Tag(name="user", description="用户"),
 *     @SWG\Tag(name="wear", description="搭配"),
 *     @SWG\Tag(name="clothing", description="单品"),
 *     @SWG\Tag(name="system", description="系统"),
 *     @SWG\Tag(name="file", description="文件"),
 * )
 */


/**
 * @SWG\Response(
 *    response="Success",
 *    description="操作成功",
 *    @SWG\Schema(
 *        type="object",
 *        @SWG\Property(property="code",type="integer",example="200"),
 *        @SWG\Property(property="message",type="string",example="ok"),
 *        @SWG\Property(property="errors",type="string", example="[]"),
 *        @SWG\Property(property="data",type="string",example="[]"),
 *     )
 *  ),
 * @SWG\Response(
 *     response="SuccessWithId",
 *     description="操作成功",
 *     @SWG\Schema(
 *        type="object",
 *        @SWG\Property(property="code", type="integer", example="200"),
 *        @SWG\Property(property="message", type="string", example="ok"),
 *        @SWG\Property(property="errors",type="string", example="[]"),
 *        @SWG\Property(
 *           property="data",
 *           type="object",
 *           @SWG\Property(property="id",type="string", example="ID"),
 *        ),
 *     )
 *   )
 */


/**
 *
 * @SWG\Parameter(
 *   parameter="id",
 *   name="id",
 *   type="integer",
 *   description="数据id",
 *   in="path",
 *   required=true,
 * )
 *
 * @SWG\Parameter(
 *   parameter="page",
 *   name="page",
 *   type="integer",
 *   description="当前页数",
 *   default="1",
 *   in="query",
 *   required=false,
 * )
 *
 * @SWG\Parameter(
 *   parameter="page_size",
 *   name="page_size",
 *   type="integer",
 *   description="每页记录数",
 *   enum={"10", "20", "50","200"},
 *   default="20",
 *   in="query",
 *   required=false,
 * )
 *
 */


/**
 * @SWG\Definition(
 *     definition="meta",
 *     type="object",
 *     @SWG\Property(
 *         property="pagination",
 *         type="object",
 *         @SWG\Property(property="total",type="integer", example="总记录数"),
 *         @SWG\Property(property="count",type="integer", example="当前返回记录数"),
 *         @SWG\Property(property="per_page",type="integer", example="每页记录数"),
 *         @SWG\Property(property="current_page",type="integer", example="当前页数"),
 *         @SWG\Property(property="total_pages",type="integer", example="总页数"),
 *         @SWG\Property(
 *              property="links",
 *              type="object",
 *              @SWG\Property(property="next",type="string", example="下一页地址"),
 *         ),
 *      ),
 *  )
 *
 *  @SWG\Definition(
 *     definition="success",
 *     @SWG\Property(property="code",type="integer",example="200"),
 *     @SWG\Property(property="message",type="string",example="ok"),
 *     @SWG\Property(property="errors",type="string",example="[]"),
 * )
 *
 */




