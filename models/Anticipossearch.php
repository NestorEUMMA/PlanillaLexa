<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Anticipos;

/**
 * Anticipossearch represents the model behind the search form about `app\models\Anticipos`.
 */
class Anticipossearch extends Anticipos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAnticipo', 'IdEmpleado'], 'integer'],
            [['FechaAnticipos', 'MesPeriodoAnticipo', 'AnoPeriodoAnticipo'], 'safe'],
            [['MontoAnticipo'], 'number'],
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
        $query = Anticipos::find();

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
            'IdAnticipo' => $this->IdAnticipo,
            'IdEmpleado' => $this->IdEmpleado,
            'MontoAnticipo' => $this->MontoAnticipo,
        ]);

        $query->andFilterWhere(['like', 'FechaAnticipos', $this->FechaAnticipos])
            ->andFilterWhere(['like', 'MesPeriodoAnticipo', $this->MesPeriodoAnticipo])
            ->andFilterWhere(['like', 'AnoPeriodoAnticipo', $this->AnoPeriodoAnticipo]);

        return $dataProvider;
    }
}
