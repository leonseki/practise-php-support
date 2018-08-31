<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tb_student_basic_info".
 *
 * @property int $id 自增ID
 * @property string $student_id 学号
 * @property string $name 学生姓名
 * @property int $sex 性别(0=未知, 1=男性, 2=女性)
 * @property int $age 年龄
 * @property string $id_number 身份证号
 * @property string $origin 生源地
 * @property string $high_school 毕业中学
 * @property string $residence 家庭居住地
 * @property string $census_register 户籍所在地
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class StudentBasicInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '%student_basic_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sex', 'age', 'created_at', 'updated_at'], 'integer'],
            [['student_id', 'name'], 'string', 'max' => 20],
            [['id_number', 'origin', 'high_school', 'residence', 'census_register'], 'string', 'max' => 255],
            [['student_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                => '自增ID',
            'student_id'        => '学号',
            'name'              => '姓名',
            'sex'               => '性别',
            'age'               => '年龄',
            'id_number'         => '身份证号',
            'origin'            => '生源地',
            'high_school'       => '毕业中学',
            'residence'         => '家庭地址',
            'census_register'   => '户籍所在地',
            'created_at'        => '创建时间',
            'updated_at'        => '更新时间',
        ];
    }
}
