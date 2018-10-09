<?php

namespace backend\controllers;

use backend\models\search\AppkeySearch;
use common\models\Appkey;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class AppkeyController
 * @package backend\controllers
 */
class AppkeyController extends BaseController
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
     * appkey 列表
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
        $query = Appkey::find()->select(['app_id', 'app_key', 'app_secret', 'label', 'state', 'created_at']);
        $searchModel = new AppkeySearch();
        $dataProvider = $searchModel->search($query, [
            $searchModel->formName() => Yii::$app->request->queryParams,
        ]);

        // 数据集合
        $dataList = [];

        // 记录总数
        $totalCount = $dataProvider->getTotalCount();

        // 格式化数据输出
        if ($totalCount > 0) {
            foreach ($dataProvider->models as $model) {
                $arr = $model->attributes;
                $dataList[] = [
                    'app_id' => $arr['app_id'],
                    'app_key' => $arr['app_key'],
                    'app_secret' => $arr['app_secret'],
                    'label' => $arr['label'],
                    'state' => $arr['state'],
                    'created_at' => Yii::$app->formatter->asDatetime($arr['created_at']),

                ];
            }
        }
        $this->layuiListResponeJson('', $totalCount, $dataList);
    }

    /**
     * 添加Appkey
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $model = new Appkey();
        if ($this->isAjax === false) {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

        $model->load([$model->formName() => $this->request->post()]);

        //生成随机码
        $model->app_key    = md5(microtime().mt_rand(1,9999));
        $model->app_secret = md5(microtime().mt_rand(1,9999));

        $errors = [];
        if ($model->validate() === false) {
            $errors = $model->getFirstErrors();
        }
        if (!empty($errors)) {
            $this->failResponseJson(implode(',', $errors));
        }
        if ($model->save()) {
            $this->successResponseJson('添加成功', ['app_id' => $model->app_id]);
        } else {
            $this->failResponseJson('添加失败');
        }

    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $postData = $this->request->post();
        foreach ($postData as $k => $v) {
            if (trim($v) == '') {
                $this->failResponseJson('不允许为空');
            } else {
                $model[$k] = trim($v);
            }
        }
        if ($model->save() !== false) {
            $this->successResponseJson('修改成功', ['app_id' => $model->app_id]);
        } else {
            $this->failResponseJson('修改失败');
        }
    }

    public function actionView()
    {
        return $this->render('view');
    }

    /**
     * 获取数据模型
     *
     * @param $id
     * @return Appkey
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Appkey::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('页面不存在或已删除');
    }

}
