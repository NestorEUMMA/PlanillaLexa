<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rptrentaanual;

/**
 * ReporteanuarentaSearch represents the model behind the search form about `app\models\Rptrentaanual`.
 */
class ReporteanuarentaSearch extends Rptrentaanual
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Idrptrentaanual', 'IdEmpleado'], 'integer'],
            [['Descripcion', 'Nit', 'CodigoIngreso', 'Anio', 'Mes', 'FechaCreacion', 'Quincena'], 'safe'],
            [['MontoDevengado', 'ImpuestoRetenido', 'AguinaldoExento', 'AguinaldoGravado', 'Isss', 'Afp', 'Ipsfa', 'BienestarMagisterial'], 'number'],
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
        $query = Rptrentaanual::find()
        ->orderBy(['Idrptrentaanual' => SORT_DESC]);;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
         'query' => $query,
                   'pagination' => [
           'pagesize' => 200,
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
            'Idrptrentaanual' => $this->Idrptrentaanual,
            'IdEmpleado' => $this->IdEmpleado,
            'MontoDevengado' => $this->MontoDevengado,
            'ImpuestoRetenido' => $this->ImpuestoRetenido,
            'AguinaldoExento' => $this->AguinaldoExento,
            'AguinaldoGravado' => $this->AguinaldoGravado,
            'Isss' => $this->Isss,
            'Afp' => $this->Afp,
            'Ipsfa' => $this->Ipsfa,
            'BienestarMagisterial' => $this->BienestarMagisterial,
            'FechaCreacion' => $this->FechaCreacion,
        ]);

        $query->andFilterWhere(['like', 'Descripcion', $this->Descripcion])
            ->andFilterWhere(['like', 'Nit', $this->Nit])
            ->andFilterWhere(['like', 'CodigoIngreso', $this->CodigoIngreso])
            ->andFilterWhere(['like', 'Anio', $this->Anio])
            ->andFilterWhere(['like', 'Mes', $this->Mes])
            ->andFilterWhere(['like', 'Quincena', $this->Quincena]);

        return $dataProvider;
    }
}
