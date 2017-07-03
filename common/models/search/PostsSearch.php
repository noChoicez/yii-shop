<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PostsModel;

/**
 * PostsSearch represents the model behind the search form of `common\models\PostsModel`.
 */
class PostsSearch extends PostsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cat_id', 'create_time', 'is_show', 'is_open'], 'integer'],
            [['posts_title', 'posts_image', 'posts_keyword', 'posts_link', 'posts_desc', 'posts_content'], 'safe'],
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
        $query = PostsModel::find();

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
            'create_time' => $this->create_time,
            'is_show' => $this->is_show,
            'is_open' => $this->is_open,
        ]);

        $query->andFilterWhere(['like', 'posts_title', $this->posts_title])
            ->andFilterWhere(['like', 'posts_image', $this->posts_image])
            ->andFilterWhere(['like', 'posts_keyword', $this->posts_keyword])
            ->andFilterWhere(['like', 'posts_link', $this->posts_link])
            ->andFilterWhere(['like', 'posts_desc', $this->posts_desc])
            ->andFilterWhere(['like', 'posts_content', $this->posts_content]);

        return $dataProvider;
    }
}
