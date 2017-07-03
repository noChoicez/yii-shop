<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GoodsCategoryModel;

/**
 * GoodsCategorySearch represents the model behind the search form of `common\models\GoodsCategoryModel`.
 */
class GoodsCategorySearch extends GoodsCategoryModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level', 'parent_id', 'order', 'is_show'], 'integer'],
            [['cat_name', 'cat_path', 'cat_image', 'cat_desc'], 'safe'],
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
        $query = GoodsCategoryModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 100,],
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
            'level' => $this->level,
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            'is_show' => $this->is_show,
        ]);

        $query->andFilterWhere(['like', 'cat_name', $this->cat_name])
            ->andFilterWhere(['like', 'cat_path', $this->cat_path])
            ->andFilterWhere(['like', 'cat_image', $this->cat_image])
            ->andFilterWhere(['like', 'cat_desc', $this->cat_desc]);

        //$query->addOrderBy(['cat_path' => SORT_ASC]);

        $query->addOrderBy(['length(substring_index(cat_path,"-",1))' => SORT_ASC])
        	->addOrderBy(['substring_index(cat_path,"-",1)' => SORT_ASC])
            ->addOrderBy(['length(substring_index(cat_path,"-",2))' => SORT_ASC])
            ->addOrderBy(['cat_path' => SORT_ASC]);
			;
        return $dataProvider;
    }
}
