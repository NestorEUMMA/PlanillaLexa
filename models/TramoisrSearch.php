<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tramoisr;

/**
 * TramoisrSearch represents the model behind the search form about `app\models\Tramoisr`.
 */
class TramoisrSearch extends Tramoisr
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdTramoIsr'], 'integer'],
            [['NumTramo', 'TramoFormaPago'], 'safe'],
            [['TramoDesde', 'TramoHasta', 'TramoAplicarPorcen', 'TramoExceso', 'TramoCuota'], 'number'],
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
        $query = Tramoisr::find();

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
            'IdTramoIsr' => $this->IdTramoIsr,
            'TramoDesde' => $this->TramoDesde,
            'TramoHasta' => $this->TramoHasta,
            'TramoAplicarPorcen' => $this->TramoAplicarPorcen,
            'TramoExceso' => $this->TramoExceso,
            'TramoCuota' => $this->TramoCuota,
        ]);

        $query->andFilterWhere(['like', 'NumTramo', $this->NumTramo])
            ->andFilterWhere(['like', 'TramoFormaPago', $this->TramoFormaPago]);

        return $dataProvider;
    }
}
