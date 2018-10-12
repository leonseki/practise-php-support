<?php

namespace api\component\auth;

use api\component\exception\InputInvalidApiException;
use common\models\Appkey;
use yii\base\ActionFilter;
use Yii;
class SignAuth extends ActionFilter
{
    /**
     * appKey参数名定义
     * @var string
     */
    protected $appKeyParam = 'appkey';

    /**
     * timestamp参数名定义
     * @var string
     */
    protected $timestampParam = 'timestamp';

    /**
     * sign参数名定义
     * @var string
     */
    protected $signParam = 'sign';

    /**
     * Api调试开关(false=关闭, true=开启)
     * @var bool
     */
    protected $apiDebugOpen = false;

    /**
     * 签名过期秒数
     * @var integer
     */
    public $expires = 1800;


    /**
     * @param \yii\base\Action $action
     * @return bool|void
     * @throws InputInvalidApiException
     */
    public function beforeAction($action)
    {
        // 当前时间
        $nowTime = time();

        // 接受公共参数
        $appKey         = trim(Yii::$app->request->getHeaders()->get($this->appKeyParam));
        $timestamp      = trim(Yii::$app->request->getHeaders()->get($this->timestampParam));
        $sign           = trim(Yii::$app->request->getHeaders()->get($this->signParam));
        $debugKey       = trim(Yii::$app->request->getHeaders()->get($this->signParam));
        // $clientIp   = trim(Yii::$app->request->getHeaders()->get('client-ip'));
        $debugSkipCache = trim(Yii::$app->request->getHeaders()->get('debug-skip-cache', 0));

        // 检查公共参数
        if (empty($appKey) || empty($timestamp) || empty($sign)) {
            throw new InputInvalidApiException(sprintf('Request parameter (%s, %s, %s) cannot be empty', $this->appKeyParam, $this->timestampParam, $this->signParam));
        }

        // 确定是否开始debug模式
        if (!empty($debugKey)) {
            $this->apiDebugOpen = ($debugKey == md5(date('Ymd').'-'.$appKey.'-'.$timestamp)) ? true : false;
        } else {
            $this->apiDebugOpen = false;
        }

        // 未开启debug模式时验证是否过期
        if ($this->apiDebugOpen === false) {
            // 过期或者超期（应用服务或调用服务器时间错乱导致与正常时间出现偏差）
            if (($timestamp < $nowTime - $this->expires) || ($timestamp > $nowTime + $this->expires)) {
                throw new InputInvalidApiException('Request is expired');
            }
        }

        // 定义跳过缓存常量
        define('DEBUG_SKIP_CACHE', $debugSkipCache);

        // 检查AppKey的有效性
        $appKeyModel = Appkey::findOne(['app_key' => $appKey, 'status' => Appkey::STATUS_ACTIVE]);
        if (empty($appKeyModel)) {
            throw new InputInvalidApiException('AppKey is invalid');
        } else if ($appKeyModel->state != Appkey::STATE_ENABLE) {
            throw new InputInvalidApiException('AppKey is not enable');
        }

        // 请求参数合并
        $args = $this->getIsPostRequest() ? $args = Yii::$app->request->post() : Yii::$app->request->get();
        $args = array_merge($args, [
            $this->appKeyParam      => $appKey,
            $this->timestampParam   => $timestamp,
            $this->signParam        => $sign
        ]);

        // 验证签名
        if ($this->verifySign($args, $appKeyModel->app_secret, $sign) === false) {
            throw new InputInvalidApiException('Signature verification failed');
        }

        return parent::beforeAction($action);
    }

    /**
     * 判断当前请求是否是一个POST请求
     * @return bool
     */
    protected function getIsPostRequest()
    {
        return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'], 'POST');
    }

    /**
     * 创建签名
     *
     * @param $args
     * @param $appSecret
     * @return string
     */
    protected function createSign($args, $appSecret)
    {
        if (isset($args[$this->signParam])) {
            unset($args[$this->signParam]);
        }

        ksort($args);
        $requestString = '';
        foreach ($args as $k => $v) {
            $requestString .= $k . '=' . $v . ':';
        }
        $requestString = substr($requestString, 0, -1);
        $newSign = md5(md5(strtolower($requestString)).$appSecret);
        return $newSign;
    }

    protected function verifySign($args, $appSecret, $sign)
    {
        // 开启debug模式不验签
        if ($this->apiDebugOpen === true) {
            return true;
        }

        if ($this->createSign($args, $appSecret) === $sign) {
            return true;
        } else {
            return false;
        }
    }
}