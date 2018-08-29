<?php

namespace App\Http\Controllers\Api;


use App\Exceptions\Api\BadRequestException;
use Qiniu\Auth;

class FileController extends BaseController
{
    const BUCKET_IMAGES = 'images';

    private static $buckets = [
        self::BUCKET_IMAGES => 'bucket_images'
    ];

    /**
     * @SWG\Get(
     *    tags={"file"},
     *    path="/file/token/{bucket}",
     *    summary="获取上传文件token",
     *    description="获取上传文件token",
     *    security={{"need_login": {}}},
     *    @SWG\Parameter(
     *        name="bucket",
     *        in="path",
     *        description="bucket：图片使用images",
     *        required=true,
     *        type="string"
     *    ),
     *    @SWG\Response(
     *        response=200,
     *        description="操作成功",
     *        @SWG\Schema(
     *            type="object",
     *            ref="$/definitions/success",
     *            @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 @SWG\Property(property="token", type="string",example="token"),
     *             ),
     *        )
     *    )
     * )
     */
    public function getUploadFileToken($bucket)
    {
        if (!array_key_exists($bucket, self::$buckets)) {
            throw  BadRequestException::instance('bucket 不存在');
        }

        $bucket = self::$buckets[$bucket];
        $auth = new Auth(config('services.qiniu.ak'), config('services.qiniu.sk'));
        $token = $auth->uploadToken($bucket);

        return compact('token');
    }
}
