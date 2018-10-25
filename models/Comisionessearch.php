<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Comisiones;

/**
 * Comisionessearch represents the model behind the search form about `app\models\Comisiones`.
 */
class Comisionessearch extends Comisiones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdComisiones', 'IdEmpleado', 'IdParametro'], 'integer'],
            [['MontoComision', 'ComisionPagar','MontoISRComosiones','ComisionAFP', 'ComisionISSS'], 'number'],
            [['MesPeriodoComi', 'AnoPeriodoComi', 'ConceptoComision', 'FechaComision'], 'safe'],
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
        $query = Comisiones::find();

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
            'IdComisiones' => $this->IdComisiones,
            'IdEmpleado' => $this->IdEmpleado,
            'MontoComision' => $this->MontoComision,
            'IdParametro' => $this->IdParametro,
            'ComisionPagar' => $this->ComisionPagar,
            'MontoISRComosiones' => $this->MontoISRComosiones,
            'ComisionAFP' => $this->ComisionAFP,
            'ComisionISSS' => $this->ComisionISSS,
        ]);

        $query->andFilterWhere(['like', 'MesPeriodoComi', $this->MesPeriodoComi])
            ->andFilterWhere(['like', 'AnoPeriodoComi', $this->AnoPeriodoComi])
            ->andFilterWhere(['like', 'ConceptoComision', $this->ConceptoComision])
            ->andFilterWhere(['like', 'FechaComision', $this->FechaComision]);

        return $dataProvider;
    }
}
