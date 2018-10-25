<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deduccionempleado".
 *
 * @property integer $IdDeduccionEmpleado
 * @property integer $IdEmpleado
 * @property string $SueldoEmpleado
 * @property string $DeducAfp
 * @property string $DeducIsss
 * @property string $DeducIsr
 * @property string $DeducIpsfa
 * @property string $SueldoNeto
 * @property string $FechaCalculo
 *
 * @property Empleado $idEmpleado
 */
class Deduccionempleado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deduccionempleado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'SueldoEmpleado'], 'required'],
            [['IdEmpleado'], 'integer'],
            [['SueldoEmpleado', 'DeducAfp', 'DeducIsss', 'DeducIsr', 'DeducIpsfa', 'SueldoNeto'], 'number'],
            [['FechaCalculo'], 'safe'],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdDeduccionEmpleado' => 'Id Deduccion Empleado',
            'IdEmpleado' => 'Empleado',
            'idEmpleado.fullname' => 'Empleado',
            'SueldoEmpleado' => 'Sueldo',
            'DeducAfp' => 'AFP',
            'DeducIsss' => 'ISSS',
            'DeducIsr' => 'ISR',
            'DeducIpsfa' => 'IPSFA',
            'SueldoNeto' => 'Sueldo Neto',
            'FechaCalculo' => 'Fecha Calculo',
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
