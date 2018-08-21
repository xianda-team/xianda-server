<?php

namespace App\Models;


use App\Exceptions\Model\NotFoundException;
use App\Exceptions\Model\SaveException;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Users\BaseModel
 *
 * @mixin \Eloquent
 */
class BaseModel extends Model
{

    protected $description = null;

    public function saveOrError(array $options = [])
    {
        if (!$this->save($options)) {
            throw new SaveException();
        }
    }

    public static function findOrError($id, $errMsg = null)
    {
        if (!$model = self::find($id)) {
            throw new NotFoundException($errMsg ?: '找不到' . (new static)->getDescription() . ' ' . $id);
        }

        return $model;
    }

    public function scopeFirstOrError($query, $errorMsg = null)
    {
        if (!$model = $query->first()) {
            throw new NotFoundException($errorMsg ?: '找不到指定的' . (new static)->getDescription());
        }

        return $model;
    }

    public function getDescription()
    {
        return $this->description;
    }
}