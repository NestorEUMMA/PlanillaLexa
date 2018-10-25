<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "puestoempresa".
 *
 * @property integer $IdPuestoEmpresa
 * @property integer $IdDepartamentoEmpresa
 * @property string $DescripcionPuestoEmpresa
 *
 * @property Empleado[] $empleados
 * @property Departamentoempresa $idDepartamentoEmpresa
 */
class Puestoempresa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'puestoempresa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdDepartamentoEmpresa'], 'integer'],
            [['DescripcionPuestoEmpresa'], 'string', 'max' => 45],
            [['IdDepartamentoEmpresa'], 'exist', 'skipOnError' => true, 'targetClass' => Departamentoempresa::className(), 'targetAttribute' => ['IdDepartamentoEmpresa' => 'IdDepartamentoEmpresa']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdPuestoEmpresa' => 'Id Puesto Empresa',
            'IdDepartamentoEmpresa' => 'Departamento Empresa',
            'DescripcionPuestoEmpresa' => 'Puesto Empresa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleados()
    {
        return $this->hasMany(Empleado::className(), ['IdPuestoEmpresa' => 'IdPuestoEmpresa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDepartamentoEmpresa()
    {
        return $this->hasOne(Departamentoempresa::className(), ['IdDepartamentoEmpresa' => 'IdDepartamentoEmpresa']);
    }
}
