<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comisiones".
 *
 * @property integer $IdComisiones
 * @property integer $IdEmpleado
 * @property string $MontoComision
 * @property string $MontoISRComosiones
 * @property string $MesPeriodoComi
 * @property string $AnoPeriodoComi
 * @property integer $IdParametro
 * @property string $ConceptoComision
 * @property string $ComisionPagar
 * @property string $FechaComision
 *
 * @property Empleado $idEmpleado
 * @property Parametros $idParametro
 */
class Comisiones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comisiones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'MontoComision', 'MesPeriodoComi', 'AnoPeriodoComi', 'IdParametro', 'ConceptoComision', 'ComisionPagar'], 'required'],
            [['IdEmpleado', 'IdParametro'], 'integer'],
            [['MontoComision', 'ComisionPagar','MontoISRComosiones', 'ComisionAFP', 'ComisionISSS'], 'number'],
            [['MesPeriodoComi', 'AnoPeriodoComi', 'FechaComision'], 'string', 'max' => 45],
            [['ConceptoComision'], 'string', 'max' => 500],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
            [['IdParametro'], 'exist', 'skipOnError' => true, 'targetClass' => Parametros::className(), 'targetAttribute' => ['IdParametro' => 'IdParametro']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdComisiones' => 'Id Comisiones',
            'IdEmpleado' => 'Empleado',
            'MontoComision' => 'Comision',
            'MesPeriodoComi' => 'Mes',
            'AnoPeriodoComi' => 'Año',
            'IdParametro' => 'Id Parametro',
            'ConceptoComision' => 'Concepto Comision',
            'ComisionPagar' => 'Monto a Pagar',
            'FechaComision' => 'Fecha',
            'idEmpleado.fullname' => 'Empleado',
            'MontoISRComosiones' => 'ISR',
            'ComisionAFP' => 'AFP',
            'ComisionISSS' => 'ISSS',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmpleado()
    {
        return $this->hasOne(Empleado::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdParametro()
    {
        return $this->hasOne(Parametros::className(), ['IdParametro' => 'IdParametro']);
    }
}
