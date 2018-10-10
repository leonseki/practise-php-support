<?php
namespace backend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * 系统工具
 * @package backend\controllers
 */
class ToolsController extends BaseController
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
     * 控制台首页
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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
}
