<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rptsepp;

/**
 * ReporteseppSearch represents the model behind the search form about `app\models\Rptsepp`.
 */
class ReporteseppSearch extends Rptsepp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdReporteSepp', 'IdEmpleado'], 'integer'],
            [['CodigoSepp', 'PlanillaCodigoObservacion', 'PlanillaIngresoBaseCotizacion', 'PlanillaHorasJornadaLaboral', 'PlanillaDiasCotizados', 'PlanillaCotizacionVoluntariaAfiliado', 'PlanillaCotizacionVoluntariaEmpleador', 'Nup', 'InstitucionPrevisional', 'PrimerNombre', 'SegundoNombre', 'PrimerApellido', 'SegundoApellido', 'ApellidoCasada', 'TipoDocumento', 'NumeroDocumento', 'Periodo', 'Mes'], 'safe'],
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
        $query = Rptsepp::find()
        ->orderBy(['Periodo' => SORT_DESC ,'Mes' => SORT_DESC ]);;

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
            'IdReporteSepp' => $this->IdReporteSepp,
            'IdEmpleado' => $this->IdEmpleado,
        ]);

        $query->andFilterWhere(['like', 'CodigoSepp', $this->CodigoSepp])
            ->andFilterWhere(['like', 'PlanillaCodigoObservacion', $this->PlanillaCodigoObservacion])
            ->andFilterWhere(['like', 'PlanillaIngresoBaseCotizacion', $this->PlanillaIngresoBaseCotizacion])
            ->andFilterWhere(['like', 'PlanillaHorasJornadaLaboral', $this->PlanillaHorasJornadaLaboral])
            ->andFilterWhere(['like', 'PlanillaDiasCotizados', $this->PlanillaDiasCotizados])
            ->andFilterWhere(['like', 'PlanillaCotizacionVoluntariaAfiliado', $this->PlanillaCotizacionVoluntariaAfiliado])
            ->andFilterWhere(['like', 'PlanillaCotizacionVoluntariaEmpleador', $this->PlanillaCotizacionVoluntariaEmpleador])
            ->andFilterWhere(['like', 'Nup', $this->Nup])
            ->andFilterWhere(['like', 'InstitucionPrevisional', $this->InstitucionPrevisional])
            ->andFilterWhere(['like', 'PrimerNombre', $this->PrimerNombre])
            ->andFilterWhere(['like', 'SegundoNombre', $this->SegundoNombre])
            ->andFilterWhere(['like', 'PrimerApellido', $this->PrimerApellido])
            ->andFilterWhere(['like', 'SegundoApellido', $this->SegundoApellido])
            ->andFilterWhere(['like', 'ApellidoCasada', $this->ApellidoCasada])
            ->andFilterWhere(['like', 'TipoDocumento', $this->TipoDocumento])
            ->andFilterWhere(['like', 'NumeroDocumento', $this->NumeroDocumento])
            ->andFilterWhere(['like', 'Periodo', $this->Periodo])
            ->andFilterWhere(['like', 'Mes', $this->Mes]);

        return $dataProvider;
    }
}
