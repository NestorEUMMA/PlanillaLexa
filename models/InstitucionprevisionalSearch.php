<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Institucionprevisional;

/**
 * InstitucionprevisionalSearch represents the model behind the search form about `app\models\Institucionprevisional`.
 */
class InstitucionprevisionalSearch extends Institucionprevisional
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdInstitucionPre'], 'integer'],
            [['DescripcionInstitucion'], 'safe'],
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
        $query = Institucionprevisional::find();

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
            'IdInstitucionPre' => $this->IdInstitucionPre,
        ]);

        $query->andFilterWhere(['like', 'DescripcionInstitucion', $this->DescripcionInstitucion]);

        return $dataProvider;
    }
}
