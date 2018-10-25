<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "propinas".
 *
 * @property integer $IdPropina
 * @property integer $IdEmpleado
 * @property string $Fecha
 * @property string $PropinaPeriodo
 * @property string $PropinaMes
 * @property string $MontoPropina
 *
 * @property Empleado $idEmpleado
 */
class Propinas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'propinas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'Fecha', 'PropinaPeriodo', 'PropinaMes', 'MontoPropina'], 'required'],
            [['IdEmpleado'], 'integer'],
            [['MontoPropina'], 'number'],
            [['Fecha', 'PropinaPeriodo', 'PropinaMes'], 'string', 'max' => 45],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdPropina' => 'Id Propina',
            'idEmpleado.fullname' => 'Empleado',
            'Fecha' => 'Fecha',
            'PropinaPeriodo' => 'Periodo',
            'PropinaMes' => 'Mes',
            'MontoPropina' => 'Monto',
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
