<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Aguinaldos;

/**
 * Aguinaldossearch represents the model behind the search form about `app\models\Aguinaldos`.
 */
class Aguinaldossearch extends Aguinaldos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAguinaldo', 'IdEmpleado', 'PeridoAguinaldo'], 'integer'],
            [['FechaAguinaldo'], 'safe'],
            [['MontoAguinaldo'], 'number'],
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
        $query = Aguinaldos::find();

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
            'IdAguinaldo' => $this->IdAguinaldo,
            'IdEmpleado' => $this->IdEmpleado,
            'PeridoAguinaldo' => $this->PeridoAguinaldo,
            'FechaAguinaldo' => $this->FechaAguinaldo,
            'MontoAguinaldo' => $this->MontoAguinaldo,
        ]);

        return $dataProvider;
    }
}
