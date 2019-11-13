<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopProduct;

/**
 * ShopProductSearch represents the model behind the search form of `common\models\ShopProduct`.
 */
class ShopProductSearch extends ShopProduct
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'price', 'drop_percent', 'vip', 'count', 'created_at', 'updated_at', 'owner_id'], 'integer'],
            [['name', 'steam_id', 'photo'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ShopProduct::find();

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
            'price' => $this->price,
            'drop_percent' => $this->drop_percent,
            'vip' => $this->vip,
            'count' => $this->count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'owner_id' => $this->owner_id
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'steam_id', $this->steam_id])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        return $dataProvider;
    }
}