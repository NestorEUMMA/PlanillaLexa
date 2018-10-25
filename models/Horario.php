<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "horario".
 *
 * @property integer $IdHorario
 * @property integer $IdEmpleado
 * @property string $JornadaLaboral
 * @property string $DiaLaboral
 * @property string $EntradaLaboral
 * @property string $SalidaLaboral
 *
 * @property Empleado $idEmpleado
 */
class Horario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'horario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'JornadaLaboral', 'DiaLaboral', 'EntradaLaboral', 'SalidaLaboral'], 'required'],
            [['IdEmpleado'], 'integer'],
            [['JornadaLaboral', 'DiaLaboral', 'EntradaLaboral', 'SalidaLaboral'], 'string', 'max' => 15],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdHorario' => 'Id Horario',
            'idEmpleado.fullname' => 'Empleado',
            'JornadaLaboral' => 'Jornada Laboral',
            'DiaLaboral' => 'Dia Laboral',
            'EntradaLaboral' => 'Entrada Laboral',
            'SalidaLaboral' => 'Salida Laboral',
            'fullName' => 'Empleado',
            'fullName' => Yii::t('app', 'Full Name'),
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
