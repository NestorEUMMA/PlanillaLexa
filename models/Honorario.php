<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "honorario".
 *
 * @property integer $IdHonorario
 * @property integer $IdEmpleado
 * @property string $MontoHonorario
 * @property string $MontoISRHonorarios
 * @property integer $IdParametro
 * @property string $ConceptoHonorario
 * @property string $FechaHonorario
 * @property string $MesPeriodoHono
 * @property string $AnoPeriodoHono
 * @property string $MontoPagar
* @property string $ISSSHonorario
* @property string $AFPHonorario
 *
 * @property Empleado $idEmpleado
 * @property Parametros $idParametro
 */
class Honorario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'honorario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'MontoHonorario', 'IdParametro', 'ConceptoHonorario', 'FechaHonorario', 'MesPeriodoHono', 'AnoPeriodoHono', 'MontoPagar'], 'required'],
            [['IdEmpleado', 'IdParametro'], 'integer'],
            [['MontoHonorario', 'MontoPagar' , 'MontoISRHonorarios','AFPHonorario','ISSSHonorario'], 'number'],
            [['ConceptoHonorario'], 'string', 'max' => 500],
            [['FechaHonorario', 'MesPeriodoHono', 'AnoPeriodoHono'], 'string', 'max' => 15],
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
            'IdHonorario' => 'Honorario',
            'idEmpleado.fullname' => 'Empleado',
            'MontoHonorario' => 'Honorario',
            'IdParametro' => 'Parametro',
            'ConceptoHonorario' => 'Concepto Honorario',
            'FechaHonorario' => 'Fecha',
            'MesPeriodoHono' => 'Mes',
            'AnoPeriodoHono' => 'Año',
            'MontoPagar' => 'Monto a Pagar',
            'MontoISRHonorarios' => 'ISR',
            'AFPHonorario' => 'AFP',
            'ISSSHonorario' => 'ISSS',
            'fullName' => 'Empleado',
            'IdEmpleado' => 'Empleado',
            'fullName' => Yii::t('app', 'Full Name'),
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
