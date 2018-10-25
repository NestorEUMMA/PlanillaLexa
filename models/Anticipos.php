<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anticipos".
 *
 * @property integer $IdAnticipo
 * @property integer $IdEmpleado
 * @property string $FechaAnticipos
 * @property string $MontoAnticipo
 * @property string $MesPeriodoAnticipo
 * @property string $AnoPeriodoAnticipo
 *
 * @property Empleado $idEmpleado
 */
class Anticipos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'anticipos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'FechaAnticipos', 'MontoAnticipo', 'MesPeriodoAnticipo', 'AnoPeriodoAnticipo'], 'required'],
            [['IdEmpleado'], 'integer'],
            [['MontoAnticipo'], 'number'],
            [['FechaAnticipos', 'MesPeriodoAnticipo', 'AnoPeriodoAnticipo'], 'string', 'max' => 15],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAnticipo' => 'Anticipo',
            'idEmpleado.fullname' => 'Empleado',
            'FechaAnticipos' => 'Fecha ',
            'MontoAnticipo' => 'Monto ',
            'MesPeriodoAnticipo' => 'Mes ',
            'AnoPeriodoAnticipo' => 'Año',
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
