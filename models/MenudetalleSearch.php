<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Menudetalle;

/**
 * MenudetalleSearch represents the model behind the search form about `app\models\Menudetalle`.
 */
class MenudetalleSearch extends Menudetalle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMenuDetalle', 'IdMenu'], 'integer'],
            [['DescripcionMenuDetalle', 'Url', 'Icono'], 'safe'],
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
        $query = Menudetalle::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
        'pagesize' => 100,]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'IdMenuDetalle' => $this->IdMenuDetalle,
            'IdMenu' => $this->IdMenu,
        ]);

        $query->andFilterWhere(['like', 'DescripcionMenuDetalle', $this->DescripcionMenuDetalle])
            ->andFilterWhere(['like', 'Url', $this->Url])
            ->andFilterWhere(['like', 'Icono', $this->Icono]);

        return $dataProvider;
    }
}
