<?php
namespace common\helper;

use Yii;

/**
 * 公共助手类
 * @package common\helper
 */

class CommonHelper
{
    public static function responseJson($code, $msg = '', $data = [], $errorInfo = [])
    {
        $data = [
            'code' => (int)$code,
            'msg'  => (string)$msg,
            'data' => self::arrayIsAssoc($data) ? $data : ['item' => $data],
        ];
        if (!empty($errorInfo)) {
            $data['errorInfo'] = $errorInfo;
        }
       return $data;
    }

    /**
     * 判断数组是否为关键字索引数组
     * @param $arr
     * @return bool
     */
    public static function arrayIsAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}