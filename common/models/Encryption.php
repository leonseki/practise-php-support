<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tb_encryption".
 *
 * @property int $id 自增ID
 * @property string $name 名称
 * @property string $password_hash 加密密码
 * @property string $operator 创建者
 * @property int $last_decryption_time 上一次解密时间
 * @property string $last_decryption_person 上一次解密人员
 * @property int $decrypted_times 总解密次数
 * @property int $category 类别
 * @property int $state 启用状态(1=启用,0=禁用)
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */

class Encryption extends BaseModel
{
    /**
     * 密钥
     * @var string
     */
    const KEY = 'TYRELL_SH';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%encryption}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_decryption_time', 'decrypted_times', 'category', 'state', 'created_at', 'updated_at'], 'integer'],
            [['decrypted_times'], 'required'],
            [['password_hash'], 'string', 'max' => 255],
            [['operator', 'last_decryption_person'], 'string', 'max' => 25],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                        => '自增ID',
            'password_hash'             => '加密密码',
            'operator'                  => '创建者',
            'name'                      => '密码业务名称',
            'last_decryption_time'      => '上一次解密时间',
            'last_decryption_person'    => '上一次解密人员',
            'decrypted_times'           => '总解密次数',
            'category'                  => '类别',
            'state'                     => '启用状态',
            'created_at'                => '创建时间',
            'updated_at'                => '更新时间',
        ];
    }
}
