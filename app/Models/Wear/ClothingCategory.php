<?php
/**
 * Created by PhpStorm.
 * User: wanglei
 * Date: 18/7/21
 * Time: 下午7:09
 */

namespace App\Models\Wear;


class ClothingCategory
{
    public static function category()
    {
        return [
            '1' => '上身装',
            '2' => '下身装',
            '3' => '连身装',
            '4' => '鞋',
            '5' => '包、袋',
        ];
    }

    public static function ids()
    {
        return collect(array_keys(self::category()));
    }


}