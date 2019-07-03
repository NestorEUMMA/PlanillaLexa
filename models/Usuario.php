<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $IdUsuario
 * @property string $InicioSesion
 * @property string $Nombres
 * @property string $Apellidos
 * @property string $Correo
 * @property string $Clave
 * @property integer $Activo
 * @property integer $IdPuesto
 * @property string $FechaIngreso
 * @property string $LexaAdmin
 * @property string $ImagenUsuario
 *
 * @property Puesto $idPuesto
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Activo', 'IdPuesto'], 'integer'],
            [['FechaIngreso'], 'safe'],
            [['LexaAdmin'], 'required'],
            [['InicioSesion'], 'string', 'max' => 50],
            [['Nombres', 'Apellidos', 'Correo', 'Clave'], 'string', 'max' => 100],
            [['LexaAdmin'], 'string', 'max' => 1],
            [['IdPuesto'], 'exist', 'skipOnError' => true, 'targetClass' => Puesto::className(), 'targetAttribute' => ['IdPuesto' => 'IdPuesto']],
            [['file'], 'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],

            [['ImagenUsuario'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdUsuario' => 'Id Usuario',
            'InicioSesion' => 'Inicio Sesion',
            'Nombres' => 'Nombres',
            'Apellidos' => 'Apellidos',
            'Correo' => 'Correo',
            'Clave' => 'Clave',
            'Activo' => 'Activo',
            'IdPuesto' => 'Id Puesto',
            'FechaIngreso' => 'Fecha Ingreso',
            'LexaAdmin' => 'Lexa Admin',
            'ImagenUsuario' => 'Logo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPuesto()
    {
        return $this->hasOne(Puesto::className(), ['IdPuesto' => 'IdPuesto']);
    }

    public function getFullName()
{
        return $this->Nombres.' '.$this->Apellidos;
}
}
