<?php

namespace backend\models;

use Yii;
use common\models\BaseModel;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * Admin model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Admin extends BaseModel implements IdentityInterface
{
    /**
     * 启用状态
     * @var integer
     */
    const STATE_ENABLE  = 1;        // 启用
    const STATE_DISABLE = 0;        // 禁用

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin}}'; // 这里'%'代表表的前缀
    }

    /**
     * 设定场景
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['id', 'username', 'password_hash', 'email', 'state', 'created_at', 'updated_at'],
            self::SCENARIO_UPDATE => ['password_hash', 'email', 'state', 'status', 'updated_at'],
            self::SCENARIO_DELETE => ['status', 'updated_at'],
            'change-pwd' => ['password_hash', 'updated_at'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email'], 'trim'],
            [['username', 'password_hash'], 'required', 'on' => self::SCENARIO_CREATE],
            /**
             * 这个地方会不会和场景重复？？？？
             */
            [['state', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 25],
            [['email'], 'string', 'max' => 50],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                    =>'自增ID',
            'username'              => '用户名',
            'auth_key'              => '自动登录key',
            'password_hash'         => '加密密码',
            'password_reset_token'  => '重置密码token',
            'email'                 => '邮箱',
            'last_login_ip'         => '上次登录ip',
            'last_login_time'       => '上次登录时间',
            'state'                 => '账户状态',
            'status'                => '数据状态',
            'created_at'            => '创建时间',
            'updated_at'            => '更新时间',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $model = static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }


    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}