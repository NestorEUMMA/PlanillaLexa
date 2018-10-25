<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Planilla;

/**
 * PlanillamovimientoSearch represents the model behind the search form about `app\models\Planilla`.
 */
class PlanillamovimientoSearch extends Planilla
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPlanilla', 'IdEmpleado'], 'integer'],
            [['Honorario', 'Comision', 'Bono', 'Anticipos', 'HorasExtras', 'Vacaciones', 'ISRPlanilla', 'AFPPlanilla', 'ISSSPlanilla','Incapacidades'], 'number'],
            [['MesPlanilla', 'AnioPlanilla', 'FechaTransaccion','DiasIncapacidad'], 'safe'],
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
        $query = Planilla::find()
        ->orderBy(['IdPlanilla' => SORT_DESC ,'FechaTransaccion' => SORT_DESC ]);;

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
            'IdPlanilla' => $this->IdPlanilla,
            'IdEmpleado' => $this->IdEmpleado,
            'Honorario' => $this->Honorario,
            'Comision' => $this->Comision,
            'Bono' => $this->Bono,
            'Anticipos' => $this->Anticipos,
            'HorasExtras' => $this->HorasExtras,
            'Vacaciones' => $this->Vacaciones,
            'FechaTransaccion' => $this->FechaTransaccion,
            'ISRPlanilla' => $this->ISRPlanilla,
            'AFPPlanilla' => $this->AFPPlanilla,
            'ISSSPlanilla' => $this->ISSSPlanilla,
            'Incapacidades' => $this->Incapacidades,
            'DiasIncapacidad' => $this->DiasIncapacidad,
            'Permisos' => $this->Permisos,
            'DiasPermiso' => $this->DiasPermiso,
        ]);

        $query->andFilterWhere(['like', 'MesPlanilla', $this->MesPlanilla])
            ->andFilterWhere(['like', 'AnioPlanilla', $this->AnioPlanilla]);

        return $dataProvider;
    }
}
