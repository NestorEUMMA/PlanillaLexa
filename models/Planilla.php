<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "planilla".
 *
 * @property integer $IdPlanilla
 * @property integer $IdEmpleado
 * @property string $Honorario
 * @property string $Comision
 * @property string $Bono
 * @property string $Anticipos
 * @property string $HorasExtras
 * @property string $Vacaciones
 * @property string $MesPlanilla
 * @property string $AnioPlanilla
 * @property string $FechaTransaccion
 * @property string $ISRPlanilla
 * @property string $AFPPlanilla
 * @property string $ISSSPlanilla
 * @property string $Incapacidades
 * @property string $DiasIncapacidad
 *
 * @property Empleado $idEmpleado
 */
class Planilla extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planilla';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'MesPlanilla', 'AnioPlanilla', 'FechaTransaccion'], 'required'],
            [['IdEmpleado'], 'integer'],
            [['Honorario', 'Comision', 'Bono', 'Anticipos', 'HorasExtras', 'Vacaciones', 'ISRPlanilla', 'AFPPlanilla', 'ISSSPlanilla','Incapacidades','Permisos'], 'number'],
            [['FechaTransaccion'], 'safe'],
            [['MesPlanilla', 'AnioPlanilla','DiasIncapacidad','DiasPermiso'], 'string', 'max' => 45],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdPlanilla' => 'Id Planilla',
            'IdEmpleado' => 'Empleado',
            'Honorario' => 'Honorario',
            'Comision' => 'Comision',
            'Bono' => 'Bono',
            'Anticipos' => 'Anticipos',
            'HorasExtras' => 'Horas Extras',
            'Vacaciones' => 'Vacaciones',
            'MesPlanilla' => 'Mes',
            'AnioPlanilla' => 'Periodo',
            'FechaTransaccion' => 'Fecha',
            'ISRPlanilla' => 'ISR',
            'AFPPlanilla' => 'AFP',
            'ISSSPlanilla' => 'ISSS',
            'idEmpleado.fullname' => 'Empleado',
            'Incapacidades' => 'Incapacidad',
            'DiasIncapacidad' => 'Dias Incapacidad',
            'Permisos ' => 'Permiso',
            'DiasPermiso' => 'Dias Permiso',
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
