<?php namespace App\Http\Controllers\Api\Transformers;

use App\Models\Wear\Wear;
use League\Fractal\TransformerAbstract;



/**
 * @SWG\Definition(
 *     definition="NewWear",
 *     required={"images","temperature_id"},
 *     @SWG\Property(property="images", type="string",example="搭配图片"),
 *     @SWG\Property(property="temperature_id", type="string",example="适宜气温id"),
 *     @SWG\Property(
 *         property="tags",
 *         type="array",
 *         @SWG\Items(
 *            type="string", example="牛仔套装"
 *         )
 *      ),
 * )
 *
 *  @SWG\Definition(
 *   definition="Wear",
 *   type="object",
 *   allOf={
 *      @SWG\Schema(
 *           @SWG\Property(property="id", type="integer",example="搭配id"),
 *       ),
 *       @SWG\Schema(ref="#/definitions/NewWear")
 *   }
 * )
 *
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