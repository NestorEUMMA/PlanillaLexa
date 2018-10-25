<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Banco;

/**
 * BancoSearch represents the model behind the search form about `app\models\Banco`.
 */
class BancoSearch extends Banco
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdBanco'], 'integer'],
            [['DescripcionBanco'], 'safe'],
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
        $query = Banco::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
                'pagination' => [
        'pagesize' => 10,
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
            'IdBanco' => $this->IdBanco,
        ]);

        $query->andFilterWhere(['like', 'DescripcionBanco', $this->DescripcionBanco]);

        return $dataProvider;
    }
}
