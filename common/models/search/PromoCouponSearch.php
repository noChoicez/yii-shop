<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PromoCouponModel;

/**
 * PromoCouponSearch represents the model behind the search form of `common\models\PromoCouponModel`.
 */
class PromoCouponSearch extends PromoCouponModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'range', 'create_num', 'send_num', 'use_num', 'send_type', 'send_start_time', 'send_end_time', 'use_start_time', 'use_end_time', 'create_time'], 'integer'],
            [['name', 'desc'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PromoCouponModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'range' => $this->range,
            'create_num' => $this->create_num,
            'send_num' => $this->send_num,
            'use_num' => $this->use_num,
            'send_type' => $this->send_type,
            'send_start_time' => $this->send_start_time,
            'send_end_time' => $this->send_end_time,
            'use_start_time' => $this->use_start_time,
            'use_end_time' => $this->use_end_time,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
}
