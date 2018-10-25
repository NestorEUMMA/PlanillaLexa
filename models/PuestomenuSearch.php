<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Puestomenu;

/**
 * PuestomenuSearch represents the model behind the search form about `app\models\Puestomenu`.
 */
class PuestomenuSearch extends Puestomenu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPuestoMenu', 'IdPuesto', 'IdMenu'], 'integer'],
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
        $query = Puestomenu::find();

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
            'IdPuestoMenu' => $this->IdPuestoMenu,
            'IdPuesto' => $this->IdPuesto,
            'IdMenu' => $this->IdMenu,
        ]);

        return $dataProvider;
    }
}
