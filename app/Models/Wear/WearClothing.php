<?php
/**
 * Created by PhpStorm.
 * User: wanglei
 * Date: 18/7/21
 * Time: 下午7:08
 */

namespace App\Models\Wear;

use App\Models\BaseModel;

/**
 * App\Models\Wear\WearClothing
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $wear_id
 * @property int $user_id
 * @property int $clothing_id
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class WearClothing extends BaseModel
{
    protected $table = 'wear_clothing';
    protected $description = '单品搭配关联';
}