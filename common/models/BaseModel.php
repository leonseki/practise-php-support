<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * 基础数据模型
 * @package common\models
 */
abstract class BaseModel extends ActiveRecord
{
    /**
     * 数据状态
     * @var integer
     */
    const STATUS_DELETED = 0;    // 删除状态
    const STATUS_ACTIVE  = 1;    // 活跃状态

    /**
     * 场景
     * @var string
     */
    const SCENARIO_CREATE = 'create';   // 创建
    const SCENARIO_UPDATE = 'update';   // 更新
    const SCENARIO_DELETE = 'delete';   // 删除

    /**
     * 获取[数据状态]标签集
     * @param string $key 键名
     * @return string
     */

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function getStatusLabels($key = null)
    {
        $array = [
            self::STATUS_DELETED => '删除',
            self::STATUS_ACTIVE  => '活跃',
        ];
        return self::getLabels($array, $key);
    }

    /**
     * 获取标签
     * @param   $array
     * @param   $key
     * @return  string
     */
    public static function getLabels($array, $key = null)
    {
        if ($key == null) {
            return $array;
        }else {
            return isset($array[$key]) ? $array[$key] : '';
        }
    }
}