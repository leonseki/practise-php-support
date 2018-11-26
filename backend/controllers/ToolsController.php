<?php
namespace backend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use common\models\Encryption;
use yii\web\ForbiddenHttpException;

/**
 * 系统工具
 * @package backend\controllers
 */
class ToolsController extends BaseEncryption
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
                        'actions' => ['index', 'debug-key', 'encrypt-test', 'decrypt-test'],
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
     * 控制台首页
     * @return string
     */
    public function actionIndex()
    {
        $type = $this->request->get('type');
        switch ($type) {
            case 'dk':
                return $this->render('index-dk');
                break;
            case 'en':
                return $this->render('index-en');
                break;
            case 'de':
                return $this->render('index-de');
                break;
        }

    }

    /**
     * DebugKey
     */
    public function actionDebugKey()
    {
        $appKey = $this->request->post('app_key');
        $timestamp = $this->request->post('timestamp');
        if (empty($appKey) || empty($timestamp)) {
            $this->failResponseJson('必填参数不能为空');
        }

        $debugKey = md5(date('Ymd').'-'.$appKey.'-'.$timestamp);
        $this->successResponseJson('生成成功', ['debug_key' => $debugKey]);
    }

    /**
     * 加密算法
     *
     * @param $text
     * @return string
     */
    public function actionEncryptTest()
    {
        $text = $this->request->post('text');
        $cryptograph = $this->encrypt($text);
        $this->successResponseJson('加密成功', ['cryptograph' => $cryptograph]);
    }


    /**
     * 解密算法
     *
     * @param $password
     * @return string
     */
    public function actionDecryptTest()
    {
        $cryptograph = $this->request->post('cryptograph');
        $plain_text = $this->decrypt($cryptograph);
        $this->successResponseJson('解密成功', ['plain_text' => $plain_text]);
    }
}
