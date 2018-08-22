<?php
namespace backend\controllers;

use backend\models\Admin;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm(); // 登录表单数据模型

        // 请求页面
        if ($this ->request->isGet == true) {
            return $this->render('login',[
                'model' => $model,
            ]);
        }

        // ajax提交表单
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        $model->attributes = [
            'username' => $username,
            'password' => $password,
        ];

//        var_dump($model->validate());exit;
//        if ($model->validate() == false) {
//            return '未通过验证';
//        }
//
//        $user = $model->getUser();
//        if ($user->state != Admin::STATE_ENABLE) {
//            return '账户未启用';
//        }

        // 登录并验证
       // if ($model->login()) {
        $this->successResponseJson('登录成功');
      //  }else {
      //      return '2';
        //}

    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
