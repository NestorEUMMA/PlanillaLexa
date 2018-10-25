<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tramoisss;

/**
 * TramoisssSearch represents the model behind the search form about `app\models\Tramoisss`.
 */
class TramoisssSearch extends Tramoisss
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdTramoIsss'], 'integer'],
            [['TramoIsss', 'TechoIsss', 'TechoSig'], 'number'],
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
        $query = Tramoisss::find();

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
            'IdTramoIsss' => $this->IdTramoIsss,
            'TramoIsss' => $this->TramoIsss,
            'TechoIsss' => $this->TechoIsss,
            'TechoSig' => $this->TechoSig,
        ]);

        return $dataProvider;
    }
}
