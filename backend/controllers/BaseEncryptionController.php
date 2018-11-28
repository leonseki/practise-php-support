<?php

namespace backend\controllers;

use common\models\Encryption;

abstract class BaseEncryptionController extends BaseController
{
    /**
     * 加密算法
     *
     * @param $text
     * @return string
     */
    public function encrypt($text)
    {
        $length = mb_strlen(Encryption::KEY, '8bit');
        $iv = substr(str_shuffle(str_repeat(Encryption::SEEDS, $length)), 0, $length);
        $value = openssl_encrypt(serialize($text), 'AES-128-CBC', Encryption::KEY, 0, $iv);
        if ($value === false) {
            return false;
        }
        $iv = base64_encode($iv);
        $mac = hash_hmac('sha256', $iv.$value, Encryption::KEY);
        $json = json_encode(compact('iv', 'value', 'mac'));

        if (!is_string($json)) {
            return false;
        }
        return base64_encode($json);
    }

    /**
     * 解密算法
     *
     * @param $password
     * @return string
     */
    public function decrypt($password)
    {
        $length = mb_strlen(Encryption::KEY, '8bit');
        $payload = json_decode(base64_decode($password), true);

        if (! $payload || ! is_array($payload) || ! isset($payload['iv']) || ! isset($payload['value']) || ! isset($payload['mac'])) {
            return false;
        }
        $bytes   = substr(str_shuffle(str_repeat(Encryption::SEEDS, $length)), 0, $length);
        $hash    = hash_hmac('sha256', $payload['iv'].$payload['value'], Encryption::KEY);
        $calcMac = hash_hmac('sha256', $hash, $bytes, true);
        if (! hash_equals(hash_hmac('sha256', $payload['mac'], $bytes, true), $calcMac)) {
            return false;
        }
        $iv = base64_decode($payload['iv']);
        $decrypted = openssl_decrypt($payload['value'], 'AES-128-CBC', Encryption::KEY, 0, $iv);
        if ($decrypted === false) {
            return false;
        }

        return unserialize($decrypted);
    }
}
