<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menuusuario".
 *
 * @property integer $IdMenuUsuario
 * @property integer $IdMenuDetalle
 * @property string $MenuUsuarioActivo
 * @property integer $IdUsuario
 * @property integer $IdMenu
 * @property integer $TipoPermiso
 *
 * @property Menu $idMenu
 * @property Menudetalle $idMenuDetalle
 * @property Usuario $idUsuario
 */
class Menuusuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menuusuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMenuDetalle', 'IdUsuario', 'TipoPermiso'], 'required'],
            [['IdMenuDetalle', 'IdUsuario', 'IdMenu', 'TipoPermiso'], 'integer'],
            [['MenuUsuarioActivo'], 'string', 'max' => 1],
            [['IdMenu'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['IdMenu' => 'IdMenu']],
            [['IdMenuDetalle'], 'exist', 'skipOnError' => true, 'targetClass' => Menudetalle::className(), 'targetAttribute' => ['IdMenuDetalle' => 'IdMenuDetalle']],
            [['IdUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['IdUsuario' => 'IdUsuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMenuUsuario' => 'Id Menu Usuario',
            'IdMenuDetalle' => 'Menu Detalle',
            'MenuUsuarioActivo' => 'Activo',
            'IdUsuario' => 'Usuario',
            'IdMenu' => 'Menu',
            'TipoPermiso' => 'Tipo Permiso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMenu()
    {
        return $this->hasOne(Menu::className(), ['IdMenu' => 'IdMenu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMenuDetalle()
    {
        return $this->hasOne(Menudetalle::className(), ['IdMenuDetalle' => 'IdMenuDetalle']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(Usuario::className(), ['IdUsuario' => 'IdUsuario']);
    }

        public static function getCity($city_id) 
    {
        $data=\app\models\MenuDetalle::find()
       ->where(['IdMenu'=>$city_id])
       ->select(['IdMenuDetalle AS id','DescripcionMenuDetalle AS name'])->asArray()->all();

            return $data;
        }
}
