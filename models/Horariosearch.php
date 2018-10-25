<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Horario;

/**
 * Horariosearch represents the model behind the search form about `app\models\Horario`.
 */
class Horariosearch extends Horario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdHorario', 'IdEmpleado'], 'integer'],
            [['JornadaLaboral', 'DiaLaboral', 'EntradaLaboral', 'SalidaLaboral'], 'safe'],
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
        $query = Horario::find();

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
            'IdHorario' => $this->IdHorario,
            'IdEmpleado' => $this->IdEmpleado,
        ]);

        $query->andFilterWhere(['like', 'JornadaLaboral', $this->JornadaLaboral])
            ->andFilterWhere(['like', 'DiaLaboral', $this->DiaLaboral])
            ->andFilterWhere(['like', 'EntradaLaboral', $this->EntradaLaboral])
            ->andFilterWhere(['like', 'SalidaLaboral', $this->SalidaLaboral]);

        return $dataProvider;
    }
}
