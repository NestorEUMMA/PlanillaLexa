<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permiso".
 *
 * @property integer $IdPermisos
 * @property integer $IdEmpleado
 * @property string $DiasPermiso
 * @property string $SalarioDescuento
 * @property string $FechaPermiso
 * @property string $PeriodoPermiso
 * @property string $MesPermiso
 * @property string $DescripcionPermiso
 *
 * @property Empleado $idEmpleado
 */
class Permiso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permiso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPermisos'], 'required'],
            [['IdPermisos', 'IdEmpleado'], 'integer'],
            [['SalarioDescuento'], 'number'],
            [['FechaPermiso'], 'safe'],
            [['DiasPermiso', 'PeriodoPermiso', 'MesPermiso', 'DescripcionPermiso'], 'string', 'max' => 45],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdPermisos' => 'Permisos',
            'IdEmpleado' => 'Empleado',
            'DiasPermiso' => 'Dias',
            'SalarioDescuento' => 'Salario',
            'FechaPermiso' => 'Fecha',
            'PeriodoPermiso' => 'Periodo ',
            'MesPermiso' => 'Mes',
            'DescripcionPermiso' => 'Descripcion',
            'idEmpleado.fullname' => 'Empleado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmpleado()
    {
        return $this->hasOne(Empleado::className(), ['IdEmpleado' => 'IdEmpleado']);
    }
}
