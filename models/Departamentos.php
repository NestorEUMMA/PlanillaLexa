<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "departamentos".
 *
 * @property string $IdDepartamentos
 * @property string $NombreDepartamento
 *
 * @property Municipios $idDepartamentos
 * @property Empleado[] $empleados
 * @property Empresa[] $empresas
 */
class Departamentos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'departamentos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdDepartamentos', 'NombreDepartamento'], 'required'],
            [['IdDepartamentos', 'NombreDepartamento'], 'string', 'max' => 45],
            [['IdDepartamentos'], 'exist', 'skipOnError' => true, 'targetClass' => Municipios::className(), 'targetAttribute' => ['IdDepartamentos' => 'IdDepartamentos']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdDepartamentos' => 'Id Departamentos',
            'NombreDepartamento' => 'Departamento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDepartamentos()
    {
        return $this->hasOne(Municipios::className(), ['IdDepartamentos' => 'IdDepartamentos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleados()
    {
        return $this->hasMany(Empleado::className(), ['IdDepartamentos' => 'IdDepartamentos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Empresa::className(), ['IdDepartamentos' => 'IdDepartamentos']);
    }
}
