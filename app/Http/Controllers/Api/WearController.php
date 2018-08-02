<?php

namespace App\Http\Controllers\Api;


class WearController extends BaseController
{

    /**
     * @SWG\Get(
     *     tags={"wear"},
     *     path="/wear",
     *     description="获取搭配列表",
     *     summary="获取搭配列表",
     *     security={{"need_login": {}}},
     *     @SWG\Parameter(ref="#/parameters/page"),
     *     @SWG\Parameter(ref="#/parameters/page_size"),
     *     @SWG\Parameter(
     *         name="keywords",
     *         in="query",
     *         type="string",
     *         description="搜索关键词",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="操作成功",
     *         @SWG\Schema(
     *             type="object",
     *             ref="$/definitions/success",
     *             @SWG\Property(
     *                 property="data",
     *                 type="array",
     *                 @SWG\Items(ref="#/definitions/Wear")
     *             ),
     *            @SWG\Property(property="meta", ref="#/definitions/meta"),
     *         )
     *      )
     *   )
     * )
     */
    public function index()
    {
        return [];
    }


    /**
     * @SWG\Get(
     *    tags={"wear"},
     *    path="/wear/{id}",
     *    summary="获取搭配详情",
     *    description="获取搭配详情",
     *    security={{"need_login": {}}},
     *    @SWG\Parameter(ref="$/parameters/id", description="搭配id"),
     *    @SWG\Response(
     *        response=200,
     *        description="操作成功",
     *        @SWG\Schema(
     *            type="object",
     *            ref="$/definitions/success",
     *            @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="$/definitions/Wear",
     *                 @SWG\Property(
     *                    property="clothing",
     *                    type="array",
     *                    @SWG\Items(ref="#/definitions/Clothing")
     *                )
     *            )
     *        )
     *    )
     * )
     */
    public function show($id)
    {

    }

    /**
     * @SWG\Post(
     *     tags={"wear"},
     *     path="/wear",
     *     summary="添加搭配",
     *     description="添加搭配",
     *     security={{"need_login": {}}},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="表单数据",
     *         required=true,
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="images",type="string", example="图片:必填"),
     *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         ref="#/responses/SuccessWithId"
     *    )
     * )
     */
    public function store()
    {

        return ['id' => 1];
    }

    /**
     * @SWG\Put(
     *     tags={"wear"},
     *     path="/wear/{id}",
     *     summary="更新搭配信息",
     *     description="更新搭配信息",
     *     security={{"need_login": {}}},
     *     @SWG\Parameter(ref="$/parameters/id", description="搭配id"),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="表单数据",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/NewWear")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         ref="#/responses/Success"
     *     )
     * )
     */
    public function update($id)
    {

    }

    /**
     * @SWG\Delete(
     *     tags={"wear"},
     *     path="/wear/{id}",
     *     description="删除搭配",
     *     summary="删除单品",
     *     security={{"need_login": {}}},
     *     @SWG\Parameter(ref="$/parameters/id", description="搭配id"),
     *     @SWG\Response(
     *         response=200,
     *         ref="#/responses/Success"
     *     )
     * )
     */
    public function delete($id)
    {

        //删除搭配与单品关联
        //删除搭配
    }

    /**
     * @SWG\Post(
     *     tags={"wear"},
     *     path="/wear-clothing/{id}",
     *     summary="搭配加入单品",
     *     description="搭配加入单品",
     *     security={{"need_login": {}}},
     *     @SWG\Parameter(ref="$/parameters/id", description="搭配id"),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="表单数据",
     *         required=true,
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *               property="clothing_ids",
     *               type="array",
     *               @SWG\Items(
     *                   type="integer", example="clothing_id"
     *               )
     *            ),
     *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         ref="#/responses/Success"
     *    )
     * )
     */
    public function addClothing($id)
    {

    }
}
