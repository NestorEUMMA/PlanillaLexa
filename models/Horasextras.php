<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "horasextras".
 *
 * @property integer $IdHorasExtras
 * @property integer $IdEmpleado
 * @property integer $MesPeriodoHorasExt
 * @property integer $AnoPeriodoHorasExt
 * @property string $MontoHorasExtras
 * @property string $CantidadHorasExtras
 * @property string $MontoISRHorasExtras
 * @property string $MontoHorasExtrasTot
 * @property string $FechaHorasExtras
 * @property string $TipoHoraExtra
 *
 * @property Empleado $idEmpleado
 */
class Horasextras extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'horasextras';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado', 'MesPeriodoHorasExt', 'AnoPeriodoHorasExt', 'MontoHorasExtras', 'FechaHorasExtras', 'TipoHoraExtra'], 'required'],
            [['IdEmpleado', 'MesPeriodoHorasExt', 'AnoPeriodoHorasExt','CantidadHorasExtras'], 'integer'],
            [['MontoHorasExtras','MontoISRHorasExtras','MontoHorasExtrasTot','HorasAFP','HorasISSS'], 'number'],
            [['FechaHorasExtras'], 'safe'],
            [['TipoHoraExtra'], 'string', 'max' => 45],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdHorasExtras' => 'Id Horas Extras',
            'idEmpleado.fullname' => 'Empleado',
            'MesPeriodoHorasExt' => 'Mes',
            'AnoPeriodoHorasExt' => 'Año',
            'FechaHorasExtras' => 'Fecha',
            'TipoHoraExtra' => 'Tipo de Horario',
            'MontoHorasExtras' => 'Monto',
            'MontoISRHorasExtras' => 'ISR',
            'MontoHorasExtrasTot' => 'Total Pago',
            'CantidadHorasExtras' => 'Cantidad de Horas',
            'fullName' => 'Empleado',
            'IdEmpleado' => 'Empleado',
            'HorasAFP' => 'AFP',
            'HorasISSS' => 'ISSS',
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
}
