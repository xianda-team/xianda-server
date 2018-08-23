<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Api\Transformers\ClothingTransformer;
use App\Models\Wear\Clothing;
use App\Models\Wear\ClothingCategory;
use App\Models\Wear\Wear;
use App\Models\Wear\WearClothing;

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
        $this->rule([
            'page_size' => 'numeric|max:200',
            'page' => 'numeric',
            'keywords' => 'max:50',
            'category_id' => 'in:' . ClothingCategory::ids()->implode(','),
        ]);

        $pageSize = $this->getQuery('page_size', 20);
        $keywords = $this->getQuery('keywords');
        $categoryId = $this->getQuery('category_id');

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
     *         @SWG\Schema(ref="#/definitions/NewClothing")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         ref="#/responses/SuccessWithId"
     *    )
     * )
     */
    public function store()
    {
        $this->rule([
            'images' => 'required',
            'category_id' => 'required|in:' . ClothingCategory::ids()->implode(','),
            'tags' => 'array',
        ]);

        $clothing = new Clothing();
        $clothing->images = $this->getData('images');
        $clothing->category_id = $this->getData('category_id');
        $clothing->tags = implode(',', $this->getData('tags', []));
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
     *                    type="object",
     *                    @SWG\Property(
     *                        property="data",
     *                        type="array",
     *                        @SWG\Items(ref="#/definitions/Wear")
     *                    ),
     *                )
     *            )
     *        )
     *    )
     * )
     */
    public function show($id)
    {
        $clothing = $this->findClothing($id);

        return $this->response->item($clothing, (new ClothingTransformer())->setDefaultIncludes(['wear']));
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
        $this->rule([
            'category_id' => 'required|in:' . ClothingCategory::ids()->implode(','),
            'tags' => 'array',
        ]);

        $images = $this->getData('images');
        $categoryId = $this->getData('category_id');
        $tags = $this->getData('tags', []);

        $clothing = $this->findClothing($id);
        if ($images) {
            $clothing->images = $images;
        }
        $clothing->category_id = $categoryId;
        $clothing->tags = implode(',', $tags);

        $clothing->saveOrError();

        return [];
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

        $clothing = $this->findClothing($id);

        $clothing->delete();

        return [];
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
        $this->rule([
            'wear_ids' => 'required|array'
        ]);
        $clothing = $this->findClothing($id);
        $wearIds = $this->getData('wear_ids');
        WearClothing::batchWearToClothing($clothing->id, $wearIds);

        return [];
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
        $wearClothing = WearClothing::where('user_id', \Auth::id())
            ->where('clothing_id', $id)
            ->where('wear_id', $wearId)
            ->firstOrError();

        $wearClothing->delete();

        return [];
    }

    protected function findClothing($id): Clothing
    {
        return Clothing::where('user_id', \Auth::id())->where('id', $id)->firstOrError();
    }
}
