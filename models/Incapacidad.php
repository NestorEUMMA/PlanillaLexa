<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "incapacidad".
 *
 * @property integer $IdIncapacidad
 * @property integer $IdEmpleado
 * @property string $DiasIncapacidad
 * @property string $SalarioDescuento
 * @property string $FechaIncapacidad
 * @property string $PeriodoIncapacidad
 * @property string $MesIncapacidad
 *
 * @property Empleado $idEmpleado
 */
class Incapacidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'incapacidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdIncapacidad'], 'required'],
            [['IdIncapacidad', 'IdEmpleado'], 'integer'],
            [['SalarioDescuento'], 'number'],
            [['FechaIncapacidad'], 'safe'],
            [['DiasIncapacidad', 'PeriodoIncapacidad', 'MesIncapacidad'], 'string', 'max' => 45],
            [['DescripcionIncapacidad'], 'string', 'max' => 500],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdIncapacidad' => 'Id Incapacidad',
            'IdEmpleado' => 'Empleado',
            'DiasIncapacidad' => 'Dias',
            'SalarioDescuento' => 'Descuento',
            'FechaIncapacidad' => 'Fecha',
            'PeriodoIncapacidad' => 'Periodo',
            'MesIncapacidad' => 'Mes',
            'idEmpleado.fullname' => 'Empleado',
            'DescripcionIncapacidad' => 'Motivo',
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
