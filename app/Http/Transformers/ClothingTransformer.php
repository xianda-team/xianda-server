<?php namespace App\Http\Transformers;

use App\Models\Wear\Clothing;
use League\Fractal\TransformerAbstract;

/**
 * Created by PhpStorm.
 * User: wanglei
 * Date: 18/7/26
 * Time: 下午9:30
 */
class ClothingTransformer extends TransformerAbstract
{
    public function transform(Clothing $clothing)
    {
        return [
            'id' => $clothing->id,
            'images' => $clothing->images,
            'tags' => $clothing->tags,
            'category_name' => $clothing->category_id,
        ];
    }
}