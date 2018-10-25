<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Indemnizacion;

/**
 * Indemnizacionsearch represents the model behind the search form about `app\models\Indemnizacion`.
 */
class Indemnizacionsearch extends Indemnizacion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdIndemnizacion', 'IdEmpleado', 'MesPeriodoIndem', 'AnoPeriodoIndem'], 'integer'],
            [['FechaIndemnizacion'], 'safe'],
            [['MontoIndemnizacion'], 'number'],
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
        $query = Indemnizacion::find();

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
            'IdIndemnizacion' => $this->IdIndemnizacion,
            'IdEmpleado' => $this->IdEmpleado,
            'FechaIndemnizacion' => $this->FechaIndemnizacion,
            'MesPeriodoIndem' => $this->MesPeriodoIndem,
            'AnoPeriodoIndem' => $this->AnoPeriodoIndem,
            'MontoIndemnizacion' => $this->MontoIndemnizacion,
        ]);

        return $dataProvider;
    }
}
