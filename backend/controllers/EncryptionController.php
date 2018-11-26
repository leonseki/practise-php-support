<?php

namespace backend\controllers;

use common\models\Encryption;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * 加密工具
 *
 * @package backend\controllers
 */
class EncryptionController extends BaseController
{

    /**
     * 定义行为
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'debug-key'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 初始化
     */
    public function init()
    {
        parent::init();
        // 设置admin可见
        if (Yii::$app->user->identity != null && Yii::$app->user->identity->getId() != 1) {
            throw new ForbiddenHttpException('暂无权限');
        }
    }

    /**
     * 加密工具首页
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 加密算法
     *
     * @param $text
     * @return string
     */
    protected function encrypt($text, $key = '1234567891234567')
    {
//        $algorithm = MCRYPT_BLOWFISH; // 加密算法
//        $key = Encryption::KEY;
//        $model = MCRYPT_MODE_CBC;     // 加密或解密的模式
//
//        // 初始向量
//        $iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithm, $model), MCRYPT_DEV_URANDOM);
//        $encrypted_data = mcrypt_encrypt($algorithm, $key, $text, $model, $iv);
//        $plain_text = base64_encode($encrypted_data);
//
//        return $plain_text;
        $length = mb_strlen($key, '8bit');

        if (!$length === 16) {
            return false;
        }

        $seeds  = '0123456789abcdefghijklmnopqrstuvwxyz';
        $length = 16;

        $iv = substr(str_shuffle(str_repeat($seeds, $length)), 0, $length);

        $value = openssl_encrypt(serialize($text), 'AES-128-CBC', $key, 0, $iv);

        if ($value === false) {
            return false;
        }

        $iv = base64_encode($iv);

        $mac = hash_hmac('sha256', $iv.$value, $key);

        $json = json_encode(compact('iv', 'value', 'mac'));

        if (! is_string($json)) {
            return false;
        }
        //return $text;
        //$this->decrypt(base64_encode($json));
        // return base64_encode($json);
    }

    /**
     * 解密算法
     *
     * @param $password
     * @return string
     */
    protected function decrypt($password, $key = '1234567891234567')
    {
//        $algorithm = MCRYPT_BLOWFISH; // 加密算法
//        $key = Encryption::KEY;
//        $model = MCRYPT_MODE_CBC;     // 加密或解密的模式
//
//        // 初始向量
//        $iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithm, $model), MCRYPT_DEV_URANDOM);
//        $encrypted_data = base64_decode($password);
//        $decoded = mcrypt_decrypt($algorithm, $key, $encrypted_data, $model, $iv);
//
//        return trim($decoded);

        $length = mb_strlen($key, '8bit');

        if (!$length === 16) {
            return false;
        }

        $payload = json_decode(base64_decode($password), true);

        if (! $payload || ! is_array($payload) || ! isset($payload['iv']) || ! isset($payload['value']) || ! isset($payload['mac'])) {
            return false;
        }

        $seeds  = '0123456789abcdefghijklmnopqrstuvwxyz';
        $length = 16;

        $bytes   = substr(str_shuffle(str_repeat($seeds, $length)), 0, $length);
        $hash    = hash_hmac('sha256', $payload['iv'].$payload['value'], $key);
        $calcMac = hash_hmac('sha256', $hash, $bytes, true);

        if (! hash_equals(hash_hmac('sha256', $payload['mac'], $bytes, true), $calcMac)) {
            return false;
        }

        $iv = base64_decode($payload['iv']);

        $decrypted = openssl_decrypt($payload['value'], 'AES-128-CBC', $key, 0, $iv);

        if ($decrypted === false) {
            return false;
        }

        return unserialize($decrypted);
    }

}