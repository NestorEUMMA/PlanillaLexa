<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Empresa;

/**
 * EmpresaSearch represents the model behind the search form about `app\models\Empresa`.
 */
class EmpresaSearch extends Empresa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpresa'], 'integer'],
            [['NombreEmpresa', 'Direccion', 'IdDepartamentos', 'IdMunicipios', 'GiroFiscal', 'NrcEmpresa', 'NuPatronal' ,'NitEmpresa', 'EmpleadoActivo','Representante', 'ImagenEmpresa'], 'safe'],
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
        $query = Empresa::find();

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
            'IdEmpresa' => $this->IdEmpresa,
        ]);

        $query->andFilterWhere(['like', 'NombreEmpresa', $this->NombreEmpresa])
            ->andFilterWhere(['like', 'Direccion', $this->Direccion])
            ->andFilterWhere(['like', 'IdDepartamentos', $this->IdDepartamentos])
            ->andFilterWhere(['like', 'IdMunicipios', $this->IdMunicipios])
            ->andFilterWhere(['like', 'GiroFiscal', $this->GiroFiscal])
            ->andFilterWhere(['like', 'NrcEmpresa', $this->NrcEmpresa])
            ->andFilterWhere(['like', 'NitEmpresa', $this->NitEmpresa])
            ->andFilterWhere(['like', 'Representante', $this->Representante])
            ->andFilterWhere(['like', 'NuPatronal', $this->NuPatronal])
            ->andFilterWhere(['like', 'EmpleadoActivo', $this->EmpleadoActivo])
            ->andFilterWhere(['like', 'ImagenEmpresa', $this->ImagenEmpresa]);

        return $dataProvider;
    }
}
