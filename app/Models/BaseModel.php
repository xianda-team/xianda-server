<?php

namespace App\Models;


use App\Exceptions\Model\SaveException;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Users\BaseModel
 *
 * @mixin \Eloquent
 */
class BaseModel extends Model
{

    public function saveOrError(array $options = [])
    {
        if (!$this->save($options)) {
            throw new SaveException();
        }
    }
}