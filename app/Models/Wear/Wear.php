<?php namespace App\Models\Wear;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Wear\Wear
 *
 * @mixin \Eloquent
 */
class Wear extends BaseModel
{
    use SoftDeletes;

    protected $table = 'wears';

}