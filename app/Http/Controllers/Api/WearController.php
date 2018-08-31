<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Transformers\WearTransformer;
use App\Models\Temperature;
use App\Models\Wear\Wear;
use App\Models\Wear\WearClothing;

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
        $this->rule([
            'page_size' => 'numeric|max:200',
            'page' => 'numeric',
            'keywords' => 'max:50',
        ]);

        $pageSize = $this->getQuery('page_size', 20);
        $keywords = $this->getQuery('keywords');

        $query = Wear::query()->where('user_id', \Auth::id());
        if ($keywords) {
            $query->where('tags', 'like', "%$keywords%");
        }
        $results = $query->paginate($pageSize);

        return $this->response->paginator($results, new WearTransformer());
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
     *                    type="object",
     *                    @SWG\Property(
     *                        property="data",
     *                        type="array",
     *                        @SWG\Items(ref="#/definitions/Clothing")
     *                   )
     *                )
     *            )
     *        )
     *    )
     * )
     */
    public function show($id)
    {
        $wear = $this->findWear($id);

        return $this->response->item($wear, (new WearTransformer())->setDefaultIncludes(['clothing']));
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
     *         @SWG\Schema(ref="#/definitions/NewWear")
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
            'temperature_id' => 'required|in:' . Temperature::ids()->implode(','),
            'tags' => 'array',
        ]);

        $images = $this->getData('images');
        $temperatureId = $this->getData('temperature_id');
        $tag = $this->getData('tags', []);

        $wear = new Wear();
        $wear->images = $images;
        $wear->temperature_id = $temperatureId;
        $wear->user_id = \Auth::id();
        $wear->tags = implode(',', $tag);

        $wear->saveOrError();

        return ['id' => $wear->id];
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
        $this->rule([
            'temperature_id' => 'required|in:' . Temperature::ids()->implode(','),
            'tags' => 'array',
        ]);

        $wear = $this->findWear($id);

        $images = $this->getData('images');
        $temperatureId = $this->getData('temperature_id');
        $tags = $this->getData('tags', []);

        if ($images) {
            $wear->images = $images;
        }
        $wear->temperature_id = $temperatureId;
        $wear->tags = implode(',', $tags);
        $wear->saveOrError();

        return [];
    }

    /**
     * @SWG\Delete(
     *     tags={"wear"},
     *     path="/wear/{id}",
     *     description="删除搭配",
     *     summary="删除搭配",
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
        $wear = $this->findWear($id);

        $wear->delete();

        return [];
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
        $this->rule([
            'clothing_ids' => 'required|array'
        ]);
        $wear = $this->findWear($id);
        $clothingIds = $this->getData('clothing_ids', []);
        WearClothing::batchClothingToWear($wear->id, $clothingIds);
        return [];
    }

    protected function findWear($id): Wear
    {
        return Wear::where('user_id', \Auth::id())->where('id', $id)->firstOrError();
    }
}
