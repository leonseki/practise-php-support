<?php

namespace backend\controllers;

use backend\models\search\EncryptionSearch;
use common\models\Encryption;
use Yii;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

/**
 * 加密工具
 *
 * @package backend\controllers
 */
class EncryptionController extends BaseEncryptionController
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
                    'id'                    => $arr['id'],
                    'name'                  => $arr['name'],
                    'password_hash'         => $arr['password_hash'],
                    'state'                 => $arr['state'],
                    'category_label'        => Encryption::getCategoryLabels($arr['category']),
                    'created_at'            => Yii::$app->formatter->asDatetime($arr['created_at']),
                ];
            }
        }
        $this->layuiListResponseJson('', $totalCount, $dataList);
    }

    /**
     * 添加密码
     *
     * @return string
     * @throws ErrorException
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

        // 接收参数
        $plain_text = $this->request->post('plain_text');
        $name = $this->request->post('name');

        // 校验
        if (empty($plain_text) || empty($name)) {
            throw new ErrorException('明文不能为空');
        }
        $encryption = $this->encrypt($plain_text);

        // 设置对象信息
        $model->name = $name;
        $model->password_hash = $encryption;
        $model->operator_id = Yii::$app->user->identity->getId();
        $model->last_decryption_time = Yii::$app->formatter->asDatetime(time());
        $model->last_decryption_person_id = Yii::$app->user->identity->getId();
        $model->decrypted_times = 0;

        // 错误信息提示
        $errors = [];
        if ($model->validate() === false) {
            $errors = $model->getFirstErrors();
        }
        if (!empty($errors)) {
            $this->failResponseJson(implode(',', $errors));
        }
        if ($model->save()) {
            $this->successResponseJson('添加成功');
        } else {
            $this->failResponseJson('添加失败');
        }
    }

}