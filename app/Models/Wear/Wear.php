<?php namespace App\Models\Wear;

use App\Exceptions\Model\DeleteException;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Wear\Wear
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $temperature_id       气温id
 * @property int $user_id              用户id
 * @property string|null $images
 * @property string|null $tags
 * @property string|null $image_width
 * @property string|null $image_height
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Wear extends BaseModel
{
    use SoftDeletes;

    protected $table = 'wears';
    protected $description = '搭配';

    protected function bootIfNotBooted()
    {
        self::saving(function (self $wear) {
            if ($wear->isDirty('images')) {
                list($width, $height) = getimagesize($wear->images);
                $wear->image_width = $width;
                $wear->image_height = $height;
            }
        });

        parent::bootIfNotBooted();
    }

    public function getTagsAttribute($value)
    {
        return array_filter(explode(',', $value));
    }

    public function clothing()
    {
        return $this->belongsToMany(Clothing::class, 'wear_clothing');
    }

    public function delete()
    {
        \DB::beginTransaction();

        try {
            // 删除搭配与单品关联
            WearClothing::where('user_id', \Auth::id())
                ->where('wear_id', $this->id)
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