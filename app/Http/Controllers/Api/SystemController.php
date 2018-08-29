<?php

namespace App\Http\Controllers\Api;


use App\Exceptions\Api\BadRequestException;
use App\Models\Temperature;
use App\Models\Wear\ClothingCategory;
use Qiniu\Auth;

class SystemController extends BaseController
{

    /**
     * @SWG\Get(
     *     tags={"system"},
     *     path="/system/config",
     *     description="获取系统配置",
     *     summary="获取系统配置",
     *     @SWG\Response(
     *         response=200,
     *         description="操作成功",
     *         @SWG\Schema(
     *             type="object",
     *             ref="$/definitions/success",
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 @SWG\Property(
     *                    property="clothing_category",
     *                    type="array",
     *                    @SWG\Items(
     *                      type="object",
     *                      @SWG\Property(property="id", type="integer", example="分类id"),
     *                      @SWG\Property(property="name", type="integer", example="分类名称"),
     *                    )
     *                 ),
     *                 @SWG\Property(
     *                    property="Temperature",
     *                    type="array",
     *                    @SWG\Items(
     *                      type="object",
     *                      @SWG\Property(property="id", type="integer", example="气温id"),
     *                      @SWG\Property(property="name", type="integer", example="气温"),
     *                    )
     *                 ),
     *             ),
     *         )
     *     )
     * )
     */
    public function config()
    {
        return [
            'clothing_category' => $this->formatList(ClothingCategory::list()),
            'Temperature' => $this->formatList(Temperature::list()),
        ];
    }

    private function formatList($list)
    {
        $temp = [];
        foreach ($list as $key => $item) {
            $temp[] = [
                'id' => $key,
                'name' => $item
            ];
        }

        return $temp;
    }
}
