<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Incapacidad;

/**
 * IncapacidadSearch represents the model behind the search form about `app\models\Incapacidad`.
 */
class IncapacidadSearch extends Incapacidad
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdIncapacidad', 'IdEmpleado'], 'integer'],
            [['DiasIncapacidad', 'FechaIncapacidad', 'PeriodoIncapacidad', 'MesIncapacidad', 'DescripcionIncapacidad'], 'safe'],
            [['SalarioDescuento'], 'number'],
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
        $query = Incapacidad::find();

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
            'IdIncapacidad' => $this->IdIncapacidad,
            'IdEmpleado' => $this->IdEmpleado,
            'SalarioDescuento' => $this->SalarioDescuento,
            'FechaIncapacidad' => $this->FechaIncapacidad,
            'DescripcionIncapacidad' => $this->DescripcionIncapacidad,
        ]);

        $query->andFilterWhere(['like', 'DiasIncapacidad', $this->DiasIncapacidad])
            ->andFilterWhere(['like', 'PeriodoIncapacidad', $this->PeriodoIncapacidad])
            ->andFilterWhere(['like', 'MesIncapacidad', $this->MesIncapacidad]);

        return $dataProvider;
    }
}
