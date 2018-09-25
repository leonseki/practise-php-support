<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\search\AdminSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * 管理员权限控制器
 * @package backend\controllers
 */
class AdminController extends BaseController
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
                        'actions' => ['index', 'create', 'update'],
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
     * 账户首页列表
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        // 非ajax请求页面
        if ($this->isAjax == false) {
            return $this->render('index');
        }

        // 获取数据
        $query = Admin::find();
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search($query, [
            $searchModel->formName() => Yii::$app->request->queryParams,
        ]);

        // 数据集合
        $dataList = [];

        // 记录总数
        $totalCount = $dataProvider->getTotalCount();

        // 格式化输出数据
        if ($totalCount > 0) {
            foreach ($dataProvider->models as $model) {
                $arr = $model->attributes;
                $dataList[] = [
                    'id' => $arr['id'],
                    'username'          => $arr['username'],
                    'email'             => $arr['email'],
                    'state'             => $arr['state'],
                    'last_login_ip'     => $arr['last_login_ip'],
                    'last_login_time'   => Yii::$app->formatter->asDatetime($arr['last_login_time']),
                    'created_at'        => Yii::$app->formatter->asDatetime($arr['created_at']),
                    'updated_at'        => Yii::$app->formatter->asDatetime($arr['updated_at']),
                ];
            }
        }

        $this->layuiListResponeJson('', $totalCount, $dataList);
    }

    /**
     * 添加管理员账号
     *
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $adminModel = new Admin(['scenario' => 'create']);
        if ($this->request->isPost == false) {
            return $this->render('create', [
                'model' => $adminModel
            ]);
        }

        $username = $this->request->post('username');
        $password = $this->request->post('password');
        $email    = $this->request->post('email');

        if (strlen($password) < 4) {
            $this->failResponseJson('密码长度最小长度为4位');
        }

        $adminModel->setPassword($password);
        $adminModel->attributes = [
            'username' => $username,
            'email'    => $email,
        ];

        if ($adminModel->validate() == false) {
            $this->failResponseJson(current($adminModel->getFirstErrors()));
        }

        if (false != Admin::findOne(['username' => $adminModel->username, 'status' => Admin::STATUS_ACTIVE])) {
            $this->failResponseJson('用户名已存在,请勿重复添加');
        }

        if ($adminModel->save()) {
            $this->successResponseJson('添加成功');
        }else {
            $this->failResponseJson('添加失败');
        }
    }

    /**
     * 修改账户资料
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $adminModel = $this->findModel($id);
        $adminModel->scenario = Admin::SCENARIO_UPDATE;

        return $this->render('update', [
            'model' => $adminModel,
        ]);
    }

    /**
     * 根据ID获取数据模型
     *
     * @param $id
     * @return Admin|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('页面不存在或已删除');
    }
}