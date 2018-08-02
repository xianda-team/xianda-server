<?php namespace App\Http\Controllers\Api\Transformers;

use App\Models\Wear\Clothing;
use League\Fractal\TransformerAbstract;


/**
 * @SWG\Definition(
 *     definition="NewClothing",
 *     required={"images","category_id"},
 *     @SWG\Property(property="images", type="string",example="图片"),
 *     @SWG\Property(
 *         property="tags",
 *         type="array",
 *         @SWG\Items(
 *            type="string", example="牛仔衬衫"
 *         )
 *      ),
 *     @SWG\Property(property="category_id", type="string",example="分类id"),
 * )
 *
 * @SWG\Definition(
 *   definition="Clothing",
 *   type="object",
 *   allOf={
 *      @SWG\Schema(
 *           @SWG\Property(property="id", type="integer",example="单品id"),
 *       ),
 *       @SWG\Schema(ref="#/definitions/NewClothing")
 *   }
 * )
 */
class ClothingTransformer extends TransformerAbstract
{

    public function transform(Clothing $clothing)
    {
        return [
            'id' => $clothing->id,
            'images' => $clothing->images,
            'tags' => [],
            'category_id' => $clothing->category_id,
        ];
    }
}