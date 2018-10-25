<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bonos".
 *
 * @property integer $IdBono
 * @property integer $IdEmpleado
 * @property string $MontoBono
 * @property string $MontoISRBono
 * @property string $MesPeriodoBono
 * @property string $AnoPeriodoBono
 * @property string $FechaBono
 * @property string $ConceptoBono
 * @property string $MontoPagarBono
 * @property string $ISSSBono
 * @property string $AFPBono
 *
 * @property Empleado $idEmpleado
 */
class Bonos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bonos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'MontoBono', 'MesPeriodoBono', 'AnoPeriodoBono', 'FechaBono', 'ConceptoBono', 'MontoPagarBono'], 'required'],
            [['IdEmpleado'], 'integer'],
            [['MontoBono', 'MontoPagarBono','MontoISRBono','ISSSBono','AFPBono'], 'number'],
            [['MesPeriodoBono', 'AnoPeriodoBono', 'FechaBono'], 'string', 'max' => 15],
            [['ConceptoBono'], 'string', 'max' => 500],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdBono' => 'Id Bono',
            'idEmpleado.fullname' => 'Empleado',
            'MontoBono' => 'Bono',
            'MesPeriodoBono' => 'Mes',
            'AnoPeriodoBono' => 'Año',
            'FechaBono' => 'Fecha',
            'ConceptoBono' => 'Concepto',
            'MontoPagarBono' => 'Monto a Pagar',
            'IdEmpleado' => 'Empleado',
            'MontoISRBono' => 'ISR',
            'ISSSBono' => 'ISSS',
            'AFPBono' => 'AFP',
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
