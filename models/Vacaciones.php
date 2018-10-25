<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vacaciones".
 *
 * @property integer $IdVacaciones
 * @property integer $IdEmpleado
 * @property integer $MesPeriodoVacaciones
 * @property integer $AnoPeriodoVacaciones
 * @property string $MontoVacaciones
 * @property string $FechaVacaciones
 *
 * @property Empleado $idEmpleado
 */
class Vacaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vacaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'MesPeriodoVacaciones', 'AnoPeriodoVacaciones', 'MontoVacaciones', 'FechaVacaciones'], 'required'],
            [['IdEmpleado', 'MesPeriodoVacaciones', 'AnoPeriodoVacaciones'], 'integer'],
            [['MontoVacaciones'], 'number'],
            [['FechaVacaciones'], 'safe'],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdVacaciones' => 'Id Vacaciones',
            'IdEmpleado' => 'Empleado',
            'MesPeriodoVacaciones' => 'Mes',
            'AnoPeriodoVacaciones' => 'Año',
            'MontoVacaciones' => 'Monto',
            'FechaVacaciones' => 'Fecha',
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
