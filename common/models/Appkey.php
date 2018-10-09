<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tb_appkey".
 *
 * @property int $app_id id
 * @property string $label 标签
 * @property string $app_key appkey
 * @property string $app_secret 密钥
 * @property int $state 启用状态(0=禁用,1=启用)
 * @property int $status 数据状态(0=删除,1=正常)
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Appkey extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%appkey}}';
    }

    /**
     * 设定规则
     * @return array
     */
    public function rules()
    {
        return [
            [['state', 'status', 'created_at', 'updated_at'], 'integer'],
            [['app_key', 'app_secret'], 'required'],
            [['label'], 'string', 'max' => 20],
            [['app_key', 'app_secret'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'app_id'        => 'ID',
            'label'         => '说明标签',
            'app_key'       => 'AppKey',
            'app_secret'    => '密钥',
            'state'         => 'State',
            'status'        => 'Status',
            'created_at'    => 'Created At',
            'updated_at'    => 'Updated At',
        ];
    }
}
