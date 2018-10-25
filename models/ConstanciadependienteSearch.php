<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Empleado;

/**
 * ConstanciadependienteSearch represents the model behind the search form about `app\models\Empleado`.
 */
class ConstanciadependienteSearch extends Empleado
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'IdTipoDocumento', 'IdInstitucionPre', 'IdTipoEmpleado', 'IdEstadoCivil', 'IdPuestoEmpresa', 'IdBanco', 'JefeInmediato', 'IdDepartamentoEmpresa'], 'integer'],
            [['Nup', 'NumTipoDocumento', 'DuiExpedido', 'DuiEl', 'DuiDe', 'Genero', 'PrimerNomEmpleado', 'SegunNomEmpleado', 'PrimerApellEmpleado', 'SegunApellEmpleado', 'ApellidoCasada', 'ConocidoPor', 'FNacimiento', 'NIsss', 'MIpsfa', 'Nit', 'Direccion', 'IdDepartamentos', 'IdMunicipios', 'CorreoElectronico', 'TelefonoEmpleado', 'CelularEmpleado', 'CBancaria', 'CasoEmergencia', 'TeleCasoEmergencia', 'Dependiente1', 'FNacimientoDep1', 'Dependiente2', 'FNacimientoDep2', 'Dependiente3', 'FNacimientoDep3', 'Beneficiario', 'DocumentBeneficiario', 'NDocBeneficiario', 'FechaContratacion', 'FechaDespido', 'EmpleadoImagen', 'Profesion', 'OtrosDatos', 'HerramientasTrabajo'], 'safe'],
            [['SalarioNominal'], 'number'],
            [['DeducIsssAfp', 'NoDependiente', 'EmpleadoActivo', 'DeducIsssIpsfa'], 'boolean'],
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
        $query = Empleado::find()->andWhere([
                 '=','NoDependiente', 0])
                 ->andWhere([
                          '=','EmpleadoActivo', 1]);

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
            'IdEmpleado' => $this->IdEmpleado,
            'IdTipoDocumento' => $this->IdTipoDocumento,
            'IdInstitucionPre' => $this->IdInstitucionPre,
            'IdTipoEmpleado' => $this->IdTipoEmpleado,
            'IdEstadoCivil' => $this->IdEstadoCivil,
            'FNacimiento' => $this->FNacimiento,
            'SalarioNominal' => $this->SalarioNominal,
            'IdPuestoEmpresa' => $this->IdPuestoEmpresa,
            'IdBanco' => $this->IdBanco,
            'JefeInmediato' => $this->JefeInmediato,
            'FNacimientoDep1' => $this->FNacimientoDep1,
            'FNacimientoDep2' => $this->FNacimientoDep2,
            'FNacimientoDep3' => $this->FNacimientoDep3,
            'DeducIsssAfp' => $this->DeducIsssAfp,
            'NoDependiente' => $this->NoDependiente,
            'EmpleadoActivo' => $this->EmpleadoActivo,
            'FechaContratacion' => $this->FechaContratacion,
            'FechaDespido' => $this->FechaDespido,
            'DeducIsssIpsfa' => $this->DeducIsssIpsfa,
            'IdDepartamentoEmpresa' => $this->IdDepartamentoEmpresa,
        ]);

        $query->andFilterWhere(['like', 'Nup', $this->Nup])
            ->andFilterWhere(['like', 'NumTipoDocumento', $this->NumTipoDocumento])
            ->andFilterWhere(['like', 'DuiExpedido', $this->DuiExpedido])
            ->andFilterWhere(['like', 'DuiEl', $this->DuiEl])
            ->andFilterWhere(['like', 'DuiDe', $this->DuiDe])
            ->andFilterWhere(['like', 'Genero', $this->Genero])
            ->andFilterWhere(['like', 'PrimerNomEmpleado', $this->PrimerNomEmpleado])
            ->andFilterWhere(['like', 'SegunNomEmpleado', $this->SegunNomEmpleado])
            ->andFilterWhere(['like', 'PrimerApellEmpleado', $this->PrimerApellEmpleado])
            ->andFilterWhere(['like', 'SegunApellEmpleado', $this->SegunApellEmpleado])
            ->andFilterWhere(['like', 'ApellidoCasada', $this->ApellidoCasada])
            ->andFilterWhere(['like', 'ConocidoPor', $this->ConocidoPor])
            ->andFilterWhere(['like', 'NIsss', $this->NIsss])
            ->andFilterWhere(['like', 'MIpsfa', $this->MIpsfa])
            ->andFilterWhere(['like', 'Nit', $this->Nit])
            ->andFilterWhere(['like', 'Direccion', $this->Direccion])
            ->andFilterWhere(['like', 'IdDepartamentos', $this->IdDepartamentos])
            ->andFilterWhere(['like', 'IdMunicipios', $this->IdMunicipios])
            ->andFilterWhere(['like', 'CorreoElectronico', $this->CorreoElectronico])
            ->andFilterWhere(['like', 'TelefonoEmpleado', $this->TelefonoEmpleado])
            ->andFilterWhere(['like', 'CelularEmpleado', $this->CelularEmpleado])
            ->andFilterWhere(['like', 'CBancaria', $this->CBancaria])
            ->andFilterWhere(['like', 'CasoEmergencia', $this->CasoEmergencia])
            ->andFilterWhere(['like', 'TeleCasoEmergencia', $this->TeleCasoEmergencia])
            ->andFilterWhere(['like', 'Dependiente1', $this->Dependiente1])
            ->andFilterWhere(['like', 'Dependiente2', $this->Dependiente2])
            ->andFilterWhere(['like', 'Dependiente3', $this->Dependiente3])
            ->andFilterWhere(['like', 'Beneficiario', $this->Beneficiario])
            ->andFilterWhere(['like', 'DocumentBeneficiario', $this->DocumentBeneficiario])
            ->andFilterWhere(['like', 'NDocBeneficiario', $this->NDocBeneficiario])
            ->andFilterWhere(['like', 'EmpleadoImagen', $this->EmpleadoImagen])
            ->andFilterWhere(['like', 'Profesion', $this->Profesion])
            ->andFilterWhere(['like', 'OtrosDatos', $this->OtrosDatos])
            ->andFilterWhere(['like', 'HerramientasTrabajo', $this->HerramientasTrabajo]);

        return $dataProvider;
    }
}
