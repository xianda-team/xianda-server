<?php
/**
 * Created by PhpStorm.
 * User: wanglei
 * Date: 18/7/21
 * Time: 下午7:10
 */

namespace App\Models;


class Temperature
{
    public static function list()
    {
        return [
            '1' => '25',
            '2' => '15 ~ 20',
            '3' => '4 ~ 10',
            '4' => '0 ~ -8',
            '5' => '-12',
        ];
    }

    public static function ids()
    {
        return collect(array_keys(self::list()));
    }
}