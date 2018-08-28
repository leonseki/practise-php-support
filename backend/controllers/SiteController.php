<?php
namespace backend\controllers;

use backend\models\Admin;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    public $enableCsrfValidation = false;
    //public $defaultAction = 'login';// 修改默认的方法名

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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
          // $this->layout = false;
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
            //var_dump(Yii::$app->user->isGuest);
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

        if ($model->validate() == false) {
            $this->failResponseJson(current($model->getFirstErrors()));
        }

        /**
         * 获取登录用户启用
         */
        $user = $model->getUser();
        //var_dump($model->getUser());
        if ($user->state != Admin::STATE_ENABLE) {
            $this->failResponseJson('账户未启用');
        }

        // 登录并验证
       if ($model->login()) {
        $this->successResponseJson('登录成功');
          }else {
           $this->failResponseJson('用户名与密码不匹配');
        }

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
