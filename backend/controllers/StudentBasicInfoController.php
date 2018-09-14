<?php

namespace backend\controllers;

use common\models\StudentBasicInfo;
use yii\debug\models\timeline\DataProvider;
use yii\filters\AccessControl;
use backend\models\search\StudentBasicInfoSearch;
use Yii;

/**
 * 学生基本信息控制器
 * @package backend\controllers
 */
class StudentBasicInfoController extends BaseController
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * 学生基本信息列表
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
        $query = StudentBasicInfo::find();
        $searchModel = new StudentBasicInfoSearch();
        $dataProvider = $searchModel->search($query, [
            $searchModel->formName() => Yii::$app->request->queryParams,
        ]);

        // 数据集合
        $dataList = [];

        // 记录总数
        $totalCount = $dataProvider->getTotalCount();

        //var_dump($totalCount);exit;
        // 输出格式化
        if ($totalCount > 0) {
            foreach ($dataProvider->models as $model) {
                $arr = $model->attributes;
                $dataList[] = [
                    'id'            => $arr['id'],
                    'student_id'    => $arr['student_id'],
                    'name'          => $arr['name'],
                    'sex'           => $arr['sex'],
                    'sex_label'     => StudentBasicInfo::getSexLabels($arr['sex']),
                    'age'           => $arr['age'],
                    'id_number'     => $arr['id_number'],
                ];
            }
        }
        $this->layuiListResponeJson('', $totalCount, $dataList);
    }
}