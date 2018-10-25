<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Empleado;

/**
 * EmpleadoSearch represents the model behind the search form about `app\models\Empleado`.
 */
class EmpleadoSearch extends Empleado
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'IdTipoDocumento', 'IdInstitucionPre', 'IdTipoEmpleado', 'IdEstadoCivil', 'IdDepartamentoEmpresa', 'IdPuestoEmpresa', 'IdBanco', 'JefeInmediato'], 'integer'],
            [['Nup', 'NumTipoDocumento', 'Genero', 'PrimerNomEmpleado', 'SegunNomEmpleado', 'PrimerApellEmpleado', 'SegunApellEmpleado', 'ApellidoCasada', 'ConocidoPor', 'FNacimiento', 'NIsss', 'MIpsfa', 'Nit', 'Direccion', 'IdDepartamentos', 'IdMunicipios', 'CorreoElectronico', 'TelefonoEmpleado', 'CelularEmpleado', 'CBancaria', 'CasoEmergencia', 'TeleCasoEmergencia', 'Dependiente1', 'Dependiente2', 'Dependiente3', 'Beneficiario', 'DocumentBeneficiario', 'NDocBeneficiario','FechaContratacion', 'FechaDespido','fullName','DuiExpedido','DuiEl','DuiDe','Profesion','OtrosDatos','HerramientasTrabajo','FNacimientoDep1','FNacimientoDep2','FNacimientoDep3'], 'safe'],
            [['SalarioNominal'], 'number'],
            [['DeducIsssAfp', 'NoDependiente', 'EmpleadoActivo', 'DeducIsssIpsfa','Pensionado'], 'boolean'],
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
        $query = Empleado::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
                'pagination' => [
        'pagesize' => 40,
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
            'DeducIsssAfp' => $this->DeducIsssAfp,
            'NoDependiente' => $this->NoDependiente,
            'Pensionado' => $this->Pensionado,
            'EmpleadoActivo' => $this->EmpleadoActivo,
            'FechaContratacion' => $this->FechaContratacion,
            'FechaDespido' => $this->FechaDespido,
            'DeducIsssIpsfa' => $this->DeducIsssIpsfa,
        ]);

        $query->andFilterWhere(['like', 'Nup', $this->Nup])
            ->andFilterWhere(['like', 'NumTipoDocumento', $this->NumTipoDocumento])
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
            ->andFilterWhere(['like', 'FNacimientoDep1', $this->FNacimientoDep1])
            ->andFilterWhere(['like', 'FNacimientoDep2', $this->FNacimientoDep2])
            ->andFilterWhere(['like', 'FNacimientoDep3', $this->FNacimientoDep3])
            ->andFilterWhere(['like', 'Beneficiario', $this->Beneficiario])
            ->andFilterWhere(['like', 'DuiExpedido', $this->DuiExpedido])
            ->andFilterWhere(['like', 'DuiEl', $this->DuiEl])
            ->andFilterWhere(['like', 'DuiDe', $this->DuiDe])
            ->andFilterWhere(['like', 'Profesion', $this->Profesion])
            ->andFilterWhere(['like', 'OtrosDatos', $this->OtrosDatos])
            ->andFilterWhere(['like', 'HerramientasTrabajo', $this->HerramientasTrabajo])
            ->andFilterWhere(['like', 'DocumentBeneficiario', $this->DocumentBeneficiario])
            ->andFilterWhere(['like', 'IdDepartamentoEmpresa', $this->IdDepartamentoEmpresa])
            ->andFilterWhere(['like', 'NDocBeneficiario', $this->NDocBeneficiario]);

        return $dataProvider;
    }
}
