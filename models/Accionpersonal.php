<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accionpersonal".
 *
 * @property integer $IdAccionPersonal
 * @property integer $IdEmpleado
 * @property string $Motivo
 * @property string $Descuento
 * @property string $FechaAccion
 * @property string $PeriodoAccion
 * @property string $MesAccion
 *
 * @property Empleado $idEmpleado
 */
class Accionpersonal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accionpersonal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'Motivo', 'Descuento', 'FechaAccion', 'PeriodoAccion', 'MesAccion'], 'required'],
            [['IdEmpleado'], 'integer'],
            [['Descuento'], 'number'],
            [['Motivo'], 'string', 'max' => 1000],
            [['FechaAccion', 'PeriodoAccion', 'MesAccion'], 'string', 'max' => 45],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idEmpleado.fullname' => 'Empleado',
            'IdEmpleado' => 'Id Empleado',
            'Motivo' => 'Motivo',
            'Descuento' => 'Descuento',
            'FechaAccion' => 'Fecha Accion',
            'PeriodoAccion' => 'Periodo Accion',
            'MesAccion' => 'Mes Accion',
            'IdEmpleado' => 'Empleado',
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
