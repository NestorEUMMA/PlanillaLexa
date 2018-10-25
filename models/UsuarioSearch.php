<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuario;

/**
 * UsuarioSearch represents the model behind the search form about `app\models\Usuario`.
 */
class UsuarioSearch extends Usuario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdUsuario', 'Activo', 'IdPuesto'], 'integer'],
            [['InicioSesion', 'Nombres', 'Apellidos', 'Correo', 'Clave', 'FechaIngreso', 'LexaAdmin','ImagenUsuario'], 'safe'],
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
        $query = Usuario::find()
        ->where([
                'LexaAdmin' => [0],
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
         'pagination' => [
        'pagesize' => 20,
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
            'IdUsuario' => $this->IdUsuario,
            'Activo' => $this->Activo,
            'IdPuesto' => $this->IdPuesto,
            'FechaIngreso' => $this->FechaIngreso,
            'ImagenUsuario' => $this->ImagenUsuario
        ]);

        $query->andFilterWhere(['like', 'InicioSesion', $this->InicioSesion])
            ->andFilterWhere(['like', 'Nombres', $this->Nombres])
            ->andFilterWhere(['like', 'Apellidos', $this->Apellidos])
            ->andFilterWhere(['like', 'Correo', $this->Correo])
            ->andFilterWhere(['like', 'Clave', $this->Clave])
            ->andFilterWhere(['like', 'LexaAdmin', $this->LexaAdmin]);

        return $dataProvider;
    }
}
