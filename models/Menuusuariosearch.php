<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Menuusuario;

/**
 * MenuusuarioSearch represents the model behind the search form about `app\models\Menuusuario`.
 */
class MenuusuarioSearch extends Menuusuario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMenuUsuario', 'IdMenuDetalle', 'IdUsuario', 'IdMenu', 'TipoPermiso'], 'integer'],
            [['MenuUsuarioActivo'], 'safe'],
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
           $query = Menuusuario::find()
          ->andWhere([
                   '>','IdUsuario', 1])
                   ->andWhere([
                            '=','TipoPermiso', 1])->orderBy(['IdUsuario' => SORT_ASC ,'IdMenu' => SORT_ASC ]);

           // add conditions that should always apply here

                  $dataProvider = new ActiveDataProvider([
               'query' => $query,
                   'pagination' => [
           'pagesize' => 100,
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
            'IdMenuUsuario' => $this->IdMenuUsuario,
            'IdMenuDetalle' => $this->IdMenuDetalle,
            'IdUsuario' => $this->IdUsuario,
            'IdMenu' => $this->IdMenu,
            'TipoPermiso' => $this->TipoPermiso,
        ]);

        $query->andFilterWhere(['like', 'MenuUsuarioActivo', $this->MenuUsuarioActivo]);

        return $dataProvider;
    }
}
