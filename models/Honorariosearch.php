<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Honorario;

/**
 * Honorariosearch represents the model behind the search form about `app\models\Honorario`.
 */
class Honorariosearch extends Honorario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdHonorario', 'IdEmpleado', 'IdParametro'], 'integer'],
            [['MontoHonorario', 'MontoPagar','ISSSHonorario','AFPHonorario'], 'number'],
            [['ConceptoHonorario', 'FechaHonorario', 'MesPeriodoHono', 'AnoPeriodoHono'], 'safe'],
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
        $query = Honorario::find();

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
            'IdHonorario' => $this->IdHonorario,
            'IdEmpleado' => $this->IdEmpleado,
            'MontoHonorario' => $this->MontoHonorario,
            'IdParametro' => $this->IdParametro,
            'MontoPagar' => $this->MontoPagar,
              'AFPHonorario' => $this->AFPHonorario,
                'ISSSHonorario' => $this->ISSSHonorario,
        ]);

        $query->andFilterWhere(['like', 'ConceptoHonorario', $this->ConceptoHonorario])
            ->andFilterWhere(['like', 'FechaHonorario', $this->FechaHonorario])
            ->andFilterWhere(['like', 'MesPeriodoHono', $this->MesPeriodoHono])
            ->andFilterWhere(['like', 'AnoPeriodoHono', $this->AnoPeriodoHono]);

        return $dataProvider;
    }
}
