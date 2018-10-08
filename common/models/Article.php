<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tb_article".
 *
 * @property int $id 自增ID
 * @property string $title 文章标题
 * @property string $content 自动登录key
 * @property int $state 启用状态(1=启用,0=禁用)
 * @property int $status 数据状态(0=删除,1=正常)
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Article extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['state', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => '自增ID',
            'title'         => '文章标题',
            'content'       => '文章内容',
            'state'         => '文章状态',
            'status'        => '数据状态',
            'created_at'    => '创建日期',
            'updated_at'    => '更新日期',
        ];
    }
}
