<?php

namespace App\Http\Controllers\Api;


use App\Http\Transformers\ClothingTransformer;
use App\Models\Wear\Clothing;
use Illuminate\Support\Facades\Input;

class ClothingController extends BaseController
{

    /**
     * @SWG\Get(
     *     tags={"clothing"},
     *     path="/clothing",
     *     description="获取单品列表",
     *     summary="获取单品列表",
     *     security={{"need_login": {}}},
     *     @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         type="integer",
     *         description="当前页数",
     *         required=false,
     *         default = 1
     *     ),
     *     @SWG\Parameter(
     *         name="page_size",
     *         in="query",
     *         type="integer",
     *         description="每页记录数",
     *         enum={"10", "20", "50","200"},
     *         required=false,
     *         default = 20
     *     ),
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
     *             type="array",
     *             @SWG\Items(
     *                 type="object",
     *                 @SWG\Property(property="id", type="integer", example="用户id"),
     *                 @SWG\Property(property="gender", type="integer", example="性别:1.男 2.女"),
     *                 @SWG\Property(property="nickname", type="string", example="用户名"),
     *                 @SWG\Property(
     *                     property="profile",
     *                     type="object",
     *                     @SWG\Property(property="id", type="integer", example="用户id"),
     *                     @SWG\Property(property="avatar", type="string", example="头像"),
     *                     @SWG\Property(property="big_avatar", type="string", example="大头像"),
     *                     @SWG\Property(property="birthday", type="string", example="生日"),
     *                     @SWG\Property(property="desc", type="string", example="个人简介"),
     *                     @SWG\Property(property="remark", type="string", example="备注")
     *                 ),
     *             )
     *         )
     *     )
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
     *         ref="#/responses/Success"
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
     *    @SWG\Parameter(
     *        name="id",
     *        in="path",
     *        description="单品id",
     *        required=true,
     *        type="integer"
     *    ),
     *    @SWG\Response(
     *        response=200,
     *        description="操作成功",
     *        @SWG\Schema(
     *            type="object",
     *            @SWG\Property(property="id", type="integer",example="单品id"),
     *            @SWG\Property(property="images", type="string",example="图片"),
     *            @SWG\Property(
     *                  property="tags",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="string", example="牛仔衬衫"
     *                  )
     *            ),
     *            @SWG\Property(property="category_name", type="string",example="分类名称"),
     *            @SWG\Property(
     *                  property="wears",
     *                  type="array",
     *                  @SWG\Items(
     *                     @SWG\Property(property="id", type="string",example="搭配id"),
     *                     @SWG\Property(property="images", type="string",example="搭配图片"),
     *                     @SWG\Property(
     *                         property="tags",
     *                         type="array",
     *                         @SWG\Items(
     *                            type="string", example="牛仔套装"
     *                         )
     *                      ),
     *                  )
     *            ),
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
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="表单数据",
     *         required=true,
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="images", type="integer", example="图片:必填"),
     *             @SWG\Property(property="category_id", type="string", example="单品分类id:必填"),
     *             @SWG\Property(
     *                  property="tags",
     *                  type="array",
     *                  @SWG\Items(
     *                      type="string", example="标签：牛仔衬衫：不传清空当前标签"
     *                  )
     *            ),
     *         )
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
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         ref="#/responses/Success"
     *     )
     * )
     */
    public function delete($id)
    {

    }

    public function addToWear($id)
    {

    }

    public function removeFromWear($id)
    {

    }
}
