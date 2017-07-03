<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GoodsModel;

/**
 * GoodsSearch represents the model behind the search form of `common\models\GoodsModel`.
 */
class GoodsSearch extends GoodsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat_id', 'brand_id', 'goods_weight', 'stock_count', 'comment_count', 'click_count', 'collect_count', 'sale_count', 'create_time', 'update_time', 'is_free_shipping', 'is_new', 'is_hot', 'is_sale'], 'integer'],
            [['goods_name', 'goods_image', 'goods_number', 'goods_keyword', 'goods_desc', 'goods_remark'], 'safe'],
            [['market_price', 'shop_price', 'cost_price'], 'number'],
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
        $query = GoodsModel::find();

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
            'cat_id' => $this->cat_id,
            'brand_id' => $this->brand_id,
            'goods_weight' => $this->goods_weight,
            'market_price' => $this->market_price,
            'shop_price' => $this->shop_price,
            'cost_price' => $this->cost_price,
            'stock_count' => $this->stock_count,
            'comment_count' => $this->comment_count,
            'click_count' => $this->click_count,
            'collect_count' => $this->collect_count,
            'sale_count' => $this->sale_count,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'is_free_shipping' => $this->is_free_shipping,
            'is_new' => $this->is_new,
            'is_hot' => $this->is_hot,
            'is_sale' => $this->is_sale,
        ]);

        $query->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'goods_image', $this->goods_image])
            ->andFilterWhere(['like', 'goods_number', $this->goods_number])
            ->andFilterWhere(['like', 'goods_keyword', $this->goods_keyword])
            ->andFilterWhere(['like', 'goods_desc', $this->goods_desc])
            ->andFilterWhere(['like', 'goods_remark', $this->goods_remark]);

        return $dataProvider;
    }
}
