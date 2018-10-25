<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indemnizacion".
 *
 * @property integer $IdIndemnizacion
 * @property integer $IdEmpleado
 * @property string $FechaIndemnizacion
 * @property integer $MesPeriodoIndem
 * @property integer $AnoPeriodoIndem
 * @property string $MontoIndemnizacion
 *
 * @property Empleado $idEmpleado
 */
class Indemnizacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'indemnizacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'FechaIndemnizacion', 'MesPeriodoIndem', 'AnoPeriodoIndem', 'MontoIndemnizacion'], 'required'],
            [['IdEmpleado', 'MesPeriodoIndem', 'AnoPeriodoIndem'], 'integer'],
            [['FechaIndemnizacion'], 'safe'],
            [['MontoIndemnizacion'], 'number'],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdIndemnizacion' => 'Id Indemnizacion',
            'idEmpleado.fullname' => 'Empleado',
            'FechaIndemnizacion' => 'Fecha',
            'MesPeriodoIndem' => 'Mes ',
            'AnoPeriodoIndem' => 'Ano ',
            'MontoIndemnizacion' => 'Monto',
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
