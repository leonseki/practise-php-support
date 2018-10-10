<?php

namespace backend\controllers;

use backend\models\search\ArticleSearch;
use common\models\Article;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use yii\web\NotFoundHttpException;

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
                        'actions' => ['index', 'create', 'update', 'view', 'update-state'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
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
                    'title'         => $arr['title'],
                    'content'       => $arr['content'],
                    'state'         => $arr['state'],
                    'created_at'    => Yii::$app->formatter->asDatetime($arr['created_at']),
                ];
            }
        }
        $this->layuiListResponeJson('', $totalCount, $dataList);
    }

    /**
     * 创建文章
     *
     */
    public function actionCreate()
    {
        return $this->render('create');
    }

    /**
     * 更新文章状态
     *
     * @param $id
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdateState($id)
    {
        // 数据模型
        $articleModel = $this->findModel($id);
        // 加载数据
        $articleModel->load([$articleModel->formName() => $this->request->post()]);
        $articleModel->scenario = 'updateState';

        // 启用按钮直接更新状态
        $articleModel->state = $this->request->post()['state'];
        if ($articleModel->save() !== false) {
            $this->successResponseJson('修改成功', ['id' => $articleModel->id]);
        } else {
            $this->failResponseJson('修改失败');
        }
    }


    /**
     * 查看文章详情
     *
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'studentBasicInfoModel' => Article::findOne($id)
        ]);
    }

    /**
     * 获取数据模型
     *
     * @param $id
     * @return Article
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('页面不存在或已删除');
    }
}
