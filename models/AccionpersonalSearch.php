<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Accionpersonal;

/**
 * AccionpersonalSearch represents the model behind the search form about `app\models\Accionpersonal`.
 */
class AccionpersonalSearch extends Accionpersonal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAccionPersonal', 'IdEmpleado'], 'integer'],
            [['Motivo', 'FechaAccion', 'PeriodoAccion', 'MesAccion'], 'safe'],
            [['Descuento'], 'number'],
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
        $query = Accionpersonal::find();

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
            'IdAccionPersonal' => $this->IdAccionPersonal,
            'IdEmpleado' => $this->IdEmpleado,
            'Descuento' => $this->Descuento,
        ]);

        $query->andFilterWhere(['like', 'Motivo', $this->Motivo])
            ->andFilterWhere(['like', 'FechaAccion', $this->FechaAccion])
            ->andFilterWhere(['like', 'PeriodoAccion', $this->PeriodoAccion])
            ->andFilterWhere(['like', 'MesAccion', $this->MesAccion]);

        return $dataProvider;
    }
}
