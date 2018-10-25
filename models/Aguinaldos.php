<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aguinaldos".
 *
 * @property integer $IdAguinaldo
 * @property integer $IdEmpleado
 * @property integer $PeridoAguinaldo
 * @property string $FechaAguinaldo
 * @property string $MontoAguinaldo
 *
 * @property Empleado $idEmpleado
 */
class Aguinaldos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aguinaldos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdAguinaldo', 'IdEmpleado', 'PeridoAguinaldo', 'FechaAguinaldo', 'MontoAguinaldo'], 'required'],
            [['IdAguinaldo', 'IdEmpleado', 'PeridoAguinaldo'], 'integer'],
            [['FechaAguinaldo'], 'safe'],
            [['MontoAguinaldo'], 'number'],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdAguinaldo' => 'Id Aguinaldo',
            'idEmpleado.fullname' => 'Empleado',
            'PeridoAguinaldo' => 'Perido',
            'FechaAguinaldo' => 'Fecha',
            'MontoAguinaldo' => 'Monto',
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
