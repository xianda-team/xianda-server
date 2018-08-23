<?php namespace App\Models\Wear;

use App\Exceptions\Model\DeleteException;
use App\Exceptions\Model\ModelException;
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

    public function wear()
    {
        return $this->belongsToMany(Wear::class, 'wear_clothing');
    }

    public static function findUserClothing($id)
    {
        return Clothing::where('user_id', \Auth::id())->where('id', $id)->firstOrError();
    }

    public function delete()
    {
        \DB::beginTransaction();

        try {
            // 删除搭配与单品关联
            WearClothing::where('user_id', \Auth::id())
                ->where('clothing_id', $this->id)
                ->each(function (WearClothing $wearClothing) {
                    $wearClothing->delete();
                });
            parent::delete();
        } catch (\Exception $exception) {
            \DB::rollBack();
            throw new DeleteException();
        }

        \DB::commit();
        return true;
    }
}