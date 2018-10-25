<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vacaciones;

/**
 * VacacionesSearch represents the model behind the search form about `app\models\Vacaciones`.
 */
class VacacionesSearch extends Vacaciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdVacaciones', 'IdEmpleado', 'MesPeriodoVacaciones', 'AnoPeriodoVacaciones'], 'integer'],
            [['MontoVacaciones'], 'number'],
            [['FechaVacaciones'], 'safe'],
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
        $query = Vacaciones::find();

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
            'IdVacaciones' => $this->IdVacaciones,
            'IdEmpleado' => $this->IdEmpleado,
            'MesPeriodoVacaciones' => $this->MesPeriodoVacaciones,
            'AnoPeriodoVacaciones' => $this->AnoPeriodoVacaciones,
            'MontoVacaciones' => $this->MontoVacaciones,
            'FechaVacaciones' => $this->FechaVacaciones,
        ]);

        return $dataProvider;
    }
}
