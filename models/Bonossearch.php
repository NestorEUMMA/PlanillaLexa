<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bonos;

/**
 * Bonossearch represents the model behind the search form about `app\models\Bonos`.
 */
class Bonossearch extends Bonos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdBono', 'IdEmpleado'], 'integer'],
            [['MontoBono', 'MontoPagarBono','MontoISRBono'], 'number'],
            [['MesPeriodoBono', 'AnoPeriodoBono', 'FechaBono', 'ConceptoBono'], 'safe'],
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
        $query = Bonos::find();

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
            'IdBono' => $this->IdBono,
            'IdEmpleado' => $this->IdEmpleado,
            'MontoBono' => $this->MontoBono,
            'MontoPagarBono' => $this->MontoPagarBono,
            'MontoISRBono' => $this->MontoISRBono,
            'ISSSBono' => $this->ISSSBono,
            'AFPBono' => $this->AFPBono,
        ]);

        $query->andFilterWhere(['like', 'MesPeriodoBono', $this->MesPeriodoBono])
            ->andFilterWhere(['like', 'AnoPeriodoBono', $this->AnoPeriodoBono])
            ->andFilterWhere(['like', 'FechaBono', $this->FechaBono])
            ->andFilterWhere(['like', 'ConceptoBono', $this->ConceptoBono]);

        return $dataProvider;
    }
}
