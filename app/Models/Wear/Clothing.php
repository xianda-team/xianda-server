<?php namespace App\Models\Wear;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Wear\Clothing
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $category_id
 * @property int $user_id
 * @property string|null $images
 * @property string|null $tags
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Clothing extends BaseModel
{
    use SoftDeletes;

    protected $table = 'clothing';
    protected $description = '单品';

    public function getTagsAttribute($value)
    {
        return array_filter(explode(',', $value));
    }

}