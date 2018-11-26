<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Encryption;

class EncryptionSearch extends Encryption
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'last_decryption_time', 'decrypted_times', 'category', 'state', 'created_at', 'updated_at'], 'integer'],
            [['operator', 'password_hash', 'last_decryption_person', 'name'], 'safe']
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
            Encryption::tableName().'.id' => $this->id,
        ]);
        return $dataProvider;
    }
}
