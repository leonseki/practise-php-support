<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Appkey;

/**
 * AppkeySearch represents the model behind the search form of `common\models\Appkey`.
 */
class AppkeySearch extends Appkey
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_id', 'created_at', 'updated_at'], 'integer'],
            [['label', 'app_key', 'app_secret', 'state', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param $query
     *
     * @return ActiveDataProvider
     */
    public function search($query, $params)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->get('limit', 15),
            ],
            'sort' => [
                'defaultOrder' => [
                    'app_id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'app_id' => $this->app_id,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'app_key', $this->app_key]);

        return $dataProvider;
    }
}
