<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Api\Transformers\ClothingTransformer;
use App\Models\Wear\Clothing;

class ClothingController extends BaseController
{

    /**
     * @SWG\Get(
     *     tags={"clothing"},
     *     path="/clothing",
     *     description="获取单品列表",
     *     summary="获取单品列表",
     *     security={{"need_login": {}}},
     *     @SWG\Parameter(ref="#/parameters/page"),
     *     @SWG\Parameter(ref="#/parameters/page_size"),
     *     @SWG\Parameter(
     *         name="category_id",
     *         in="query",
     *         type="string",
     *         description="分类id，不传返回全部",
     *         required=false,
     *     ),
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
     *                 @SWG\Items(ref="#/definitions/Clothing")
     *             ),
     *            @SWG\Property(property="meta", ref="#/definitions/meta"),
     *         )
     *      )
     *   )
     * )
     */
    public function index()
    {
        $pageSize = request()->input('page_size', 30);
        $keywords = request()->input('keywords');
        $categoryId = request()->input('category_id');
        $query = Clothing::query();
        if ($keywords) {
            $query->where('tags', 'like', "%$keywords%");
        }
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        $results = $query->paginate($pageSize);

        return $this->response->paginator($results, new ClothingTransformer());
    }

    /**
     * @SWG\Post(
     *     tags={"clothing"},
     *     path="/clothing",
     *     summary="添加单品",
     *     description="添加单品",
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
        $clothing = new Clothing();
        $clothing->images = request()->input('images');
        $clothing->user_id = \Auth::id();
        $clothing->saveOrError();

        return ['id' => $clothing->id];
    }


    /**
     * @SWG\Get(
     *    tags={"clothing"},
     *    path="/clothing/{id}",
     *    summary="获取单品详情",
     *    description="获取单品详情",
     *    security={{"need_login": {}}},
     *    @SWG\Parameter(ref="$/parameters/id", description="单品id"),
     *    @SWG\Response(
     *        response=200,
     *        description="操作成功",
     *        @SWG\Schema(
     *            type="object",
     *            ref="$/definitions/success",
     *            @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="$/definitions/Clothing",
     *                 @SWG\Property(
     *                    property="wears",
     *                    type="array",
     *                    @SWG\Items(ref="#/definitions/Wear")
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
     * @SWG\Put(
     *     tags={"clothing"},
     *     path="/clothing/{id}",
     *     summary="更新单品信息",
     *     description="更新单品信息",
     *     security={{"need_login": {}}},
     *     @SWG\Parameter(ref="$/parameters/id", description="单品id"),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="表单数据",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/NewClothing")
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
     *     tags={"clothing"},
     *     path="/clothing/{id}",
     *     description="删除单品",
     *     summary="删除单品",
     *     security={{"need_login": {}}},
     *     @SWG\Parameter(ref="$/parameters/id", description="单品id"),
     *     @SWG\Response(
     *         response=200,
     *         ref="#/responses/Success"
     *     )
     * )
     */
    public function delete($id)
    {

    }

    /**
     * @SWG\Post(
     *     tags={"clothing"},
     *     path="/clothing-wear/{id}",
     *     summary="单品加入搭配",
     *     description="单品加入搭配",
     *     security={{"need_login": {}}},
     *     @SWG\Parameter(ref="$/parameters/id", description="单品id"),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="表单数据",
     *         required=true,
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *               property="wear_ids",
     *               type="array",
     *               @SWG\Items(
     *                   type="integer", example="wear_id"
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
    public function addToWear($id)
    {

    }


    /**
     * @SWG\Delete(
     *     tags={"clothing"},
     *     path="/clothing-wear/{id}/{wearId}",
     *     summary="从搭配中移除单品",
     *     description="从搭配中移除单品",
     *     security={{"need_login": {}}},
     *     @SWG\Parameter(ref="$/parameters/id", description="单品id"),
     *     @SWG\Parameter(
     *         name="wearId",
     *         type="integer",
     *         description="搭配id",
     *         in="path",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         ref="#/responses/Success"
     *    )
     * )
     */
    public function removeFromWear($id, $wearId)
    {

    }
}
