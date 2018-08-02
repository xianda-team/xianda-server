<?php namespace App\Http\Controllers\Api\Transformers;

use App\Models\Wear\Wear;
use League\Fractal\TransformerAbstract;

/**
 * @SWG\Definition(
 *     definition="Wear",
 *     @SWG\Property(property="id", type="integer",example="搭配id"),
 *     @SWG\Property(property="images", type="string",example="搭配图片"),
 *     @SWG\Property(
 *         property="tags",
 *         type="array",
 *         @SWG\Items(
 *            type="string", example="牛仔套装"
 *         )
 *      ),
 * )
 */
class WearTransformer extends TransformerAbstract
{

    public function transform(Wear $clothing)
    {
        return [
            'id' => $clothing->id,
            'images' => $clothing->images,
            'tags' => [],
        ];
    }
}