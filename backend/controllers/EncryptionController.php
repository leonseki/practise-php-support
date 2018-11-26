<?php

namespace backend\controllers;

use backend\models\search\EncryptionSearch;
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
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['POST'],
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
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        if ($this->isAjax === false) {
            return $this->render('index');
        }

        // 获取数据
        $query = Encryption::find();
        $searchModel = new EncryptionSearch();
        $dataProvider = $searchModel->search($query, [
            $searchModel->formName() => Yii::$app->request->queryParams,
        ]);

        // 数据集合
        $dataList = [];

        // 记录总数
        $totalCount = $dataProvider->getTotalCount();

        // 输出格式化
        if ($totalCount > 0) {
            foreach ($dataProvider->models as $model) {
                $arr = $model->attributes;
                $dataList[] = [
                    'id'            => $arr['id'],
                    'password_hash'         => $arr['password_hash'],
                    'state'         => $arr['state'],
                    'created_at'    => Yii::$app->formatter->asDatetime($arr['created_at']),
                ];
            }
        }
        $this->layuiListResponseJson('', $totalCount, $dataList);
    }

    /**
     * 添加密码
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $model = new Encryption();
        if ($this->isAjax === false) {
            return $this->render('create', [
                'model' => $model,
            ]);
        }


    }

}