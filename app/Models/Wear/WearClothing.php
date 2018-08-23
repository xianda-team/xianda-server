<?php
/**
 * Created by PhpStorm.
 * User: wanglei
 * Date: 18/7/21
 * Time: 下午7:08
 */

namespace App\Models\Wear;

use App\Exceptions\Model\ModelException;
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


    public static function batchClothingToWear($wearId, array $clothingIds)
    {
        \DB::beginTransaction();

        try {
            self::where('wear_id', $wearId)
                ->where('user_id', \Auth::id())
                ->each(function (self $wearClothing) {
                    $wearClothing->delete();
                });
            foreach ($clothingIds as $clothingId) {
                $wearClothing = new WearClothing();
                $wearClothing->wear_id = $wearId;
                $wearClothing->clothing_id = $clothingId;
                $wearClothing->user_id = \Auth::id();
                $wearClothing->saveOrError();
            }
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ModelException();
        }

        \DB::commit();
    }

    public static function batchWearToClothing($clothingId, array $wearIds)
    {
        \DB::beginTransaction();

        try {
            self::where('clothing_id', $clothingId)
                ->where('user_id', \Auth::id())
                ->each(function (self $wearClothing) {
                    $wearClothing->delete();
                });
            foreach ($wearIds as $wearId) {
                $wearClothing = new WearClothing();
                $wearClothing->wear_id = $wearId;
                $wearClothing->clothing_id = $clothingId;
                $wearClothing->user_id = \Auth::id();
                $wearClothing->saveOrError();
            }
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new ModelException();
        }

        \DB::commit();
    }
}