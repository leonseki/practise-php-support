<?php

namespace backend\models\search;

use common\models\StudentBasicInfo;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * Class StudentBasicInfoSearch
 * @package backend\models\search
 */

class StudentBasicInfoSearch extends StudentBasicInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'sex', 'age', 'id_number', 'created_at', 'updated_at'], 'integer'],
            [['name', 'origin', 'high_school', 'residence', 'census_register'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($query, $params)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('limit', 15),
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            StudentBasicInfo::tableName().'.id'     => $this->id,
        ]);
        return $dataProvider;
    }
}