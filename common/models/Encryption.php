<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tb_encryption".
 *
 * @property int $id 自增ID
 * @property string $name 名称
 * @property string $password_hash 加密密码
 * @property int $operator_id 创建者ID
 * @property string $last_decryption_time 上一次解密时间
 * @property int $last_decryption_person_id 上一次解密人员ID
 * @property int $decrypted_times 总解密次数
 * @property int $category 类别
 * @property int $state 启用状态(1=启用,0=禁用)
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */

class Encryption extends BaseModel
{
    /**
     * 分类
     * @var integer
     */
    const SOCIAL_ACCOUNT = 1;    // 社交账号类
    const BANK_ACCOUNT  = 2;    // 银行账号类

    /**
     * 密钥
     * @var string
     */
    const KEY = 'Trell--Shanghai.';

    /**
     * seeds
     * @var string
     */
    const SEEDS = '0123456789abcdefghijklmnopqrstuvwxyz';
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
            [['decrypted_times', 'category', 'state', 'created_at', 'updated_at', 'operator_id', 'last_decryption_person_id'], 'integer'],
            [['decrypted_times'], 'required'],
            [['last_decryption_time', 'password_hash'], 'string', 'max' => 255],
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
            'operator_id'               => '创建者',
            'name'                      => '密码业务名称',
            'last_decryption_time'      => '上一次解密时间',
            'last_decryption_person_id' => '上一次解密人员',
            'decrypted_times'           => '总解密次数',
            'category'                  => '类别',
            'state'                     => '启用状态',
            'created_at'                => '创建时间',
            'updated_at'                => '更新时间',
        ];
    }

    /**
     * 获取[类别]标签集
     * @param null $key
     * @return string
     */
    public static function getCategoryLabels($key = null)
    {
        $array = [
            self::SOCIAL_ACCOUNT  => '社交账号类',
            self::BANK_ACCOUNT   => '银行账号类',
        ];
        return self::getLabels($array, $key);
    }

}
