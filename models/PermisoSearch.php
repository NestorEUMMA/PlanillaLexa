<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Permiso;

/**
 * PermisoSearch represents the model behind the search form about `app\models\Permiso`.
 */
class PermisoSearch extends Permiso
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPermisos', 'IdEmpleado'], 'integer'],
            [['DiasPermiso', 'FechaPermiso', 'PeriodoPermiso', 'MesPermiso', 'DescripcionPermiso'], 'safe'],
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
        $query = Permiso::find();

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
            'IdPermisos' => $this->IdPermisos,
            'IdEmpleado' => $this->IdEmpleado,
            'SalarioDescuento' => $this->SalarioDescuento,
            'FechaPermiso' => $this->FechaPermiso,
        ]);

        $query->andFilterWhere(['like', 'DiasPermiso', $this->DiasPermiso])
            ->andFilterWhere(['like', 'PeriodoPermiso', $this->PeriodoPermiso])
            ->andFilterWhere(['like', 'MesPermiso', $this->MesPermiso])
            ->andFilterWhere(['like', 'DescripcionPermiso', $this->DescripcionPermiso]);

        return $dataProvider;
    }
}
