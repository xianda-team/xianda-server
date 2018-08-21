<?php namespace App\Models\Wear;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Wear\Wear
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $weather_id
 * @property int $user_id
 * @property string|null $images
 * @property string|null $tags
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Wear extends BaseModel
{
    use SoftDeletes;

    protected $table = 'wears';
    protected $description = '搭配';

}