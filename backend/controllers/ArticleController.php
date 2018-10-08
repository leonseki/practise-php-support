<?php

namespace backend\controllers;

use backend\models\search\ArticleSearch;
use common\models\Article;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

/**
 * Class 文章控制器
 * @package backend\controllers
 */
class ArticleController extends BaseController
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
                        'actions' => ['index', 'create', 'update','view'],
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
     * 文章信息列表
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
        $query = Article::find();
        $searchModel = new ArticleSearch();
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
                    'title'    => $arr['title'],
                    'content'          => $arr['content'],
                    'created_at'    => Yii::$app->formatter->asDatetime($arr['created_at']),
                ];
            }
        }
        $this->layuiListResponeJson('', $totalCount, $dataList);
    }

    /**
     * 创建学生信息
     *
     */
    public function actionCreate()
    {
        return $this->render('create');
    }

    /**
     * 查看学生详情
     *
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'studentBasicInfoModel' => Article::findOne($id)
        ]);
    }
}