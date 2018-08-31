<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Zhuzhichao\IpLocationZh\Ip;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * App\Models\Users\User
 *
 * @property int $id
 * @property string|null $wx_openid
 * @property string $mobile
 * @property string|null $email
 * @property string|null $password
 * @property string $nickname
 * @property string $register_ip
 * @property string $register_city
 * @property string|null $last_login_time
 * @property string|null $last_login_ip
 * @property string|null $last_login_city
 * @property string $gender
 * @property string|null $avatar
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class User extends BaseModel implements JWTSubject, AuthenticatableContract
{
    use Authenticatable;

    const GENDER_男 = '男';
    const GENDER_女 = '女';
    const GENDER_保密 = '保密';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function newUserFromMobileAndOpenId($mobile, $openId)
    {
        $user = new User();
        $user->mobile = $mobile;
        $user->wx_openid = $openId;
        $user->nickname = $mobile;
        $user->gender = self::GENDER_女;
        $user->register_ip = \Request::getClientIp();
        $user->register_city = Ip::find(\Request::getClientIp())[2] ?? '未知';
        $user->last_login_time = Carbon::now();
        $user->last_login_ip = \Request::getClientIp();
        $user->last_login_city = Ip::find(\Request::getClientIp())[2] ?? '未知';

        return $user;
    }
}
