<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rptrentaanual".
 *
 * @property integer $Idrptrentaanual
 * @property string $Descripcion
 * @property integer $IdEmpleado
 * @property string $Nit
 * @property string $CodigoIngreso
 * @property string $MontoDevengado
 * @property string $ImpuestoRetenido
 * @property string $AguinaldoExento
 * @property string $AguinaldoGravado
 * @property string $Isss
 * @property string $Afp
 * @property string $Ipsfa
 * @property string $BienestarMagisterial
 * @property string $Anio
 * @property string $Mes
 * @property string $FechaCreacion
 * @property string $Quincena
 *
 * @property Codigoreporteanual $codigoIngreso
 * @property Empleado $idEmpleado
 */
class Rptrentaanual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rptrentaanual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado'], 'integer'],
            [['MontoDevengado', 'ImpuestoRetenido', 'AguinaldoExento', 'AguinaldoGravado', 'Isss', 'Afp', 'Ipsfa', 'BienestarMagisterial'], 'number'],
            [['FechaCreacion'], 'safe'],
            [['Descripcion', 'Nit', 'Anio', 'Mes'], 'string', 'max' => 45],
            [['CodigoIngreso'], 'string', 'max' => 11],
            [['Quincena'], 'string', 'max' => 2],
            [['CodigoIngreso'], 'exist', 'skipOnError' => true, 'targetClass' => Codigoreporteanual::className(), 'targetAttribute' => ['CodigoIngreso' => 'CodigoIngreso']],
            [['IdEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['IdEmpleado' => 'IdEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Idrptrentaanual' => 'Idrptrentaanual',
            'Descripcion' => 'Descripcion',
            'IdEmpleado' => 'Empleado',
            'Nit' => 'Nit',
            'CodigoIngreso' => 'Codigo Ingreso',
            'MontoDevengado' => 'Monto Devengado',
            'ImpuestoRetenido' => 'Imp Retenido',
            'AguinaldoExento' => 'Agui Exe',
            'AguinaldoGravado' => 'Agui Grav',
            'Isss' => 'Isss',
            'Afp' => 'Afp',
            'Ipsfa' => 'Ipsfa',
            'BienestarMagisterial' => 'Bienestar Magisterial',
            'Anio' => 'Año',
            'Mes' => 'Mes',
            'FechaCreacion' => 'Fecha Creacion',
            'Quincena' => 'Quincena',
            'idEmpleado.fullname' => 'Empleado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodigoIngreso()
    {
        return $this->hasOne(Codigoreporteanual::className(), ['CodigoIngreso' => 'CodigoIngreso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmpleado()
    {
        return $this->hasOne(Empleado::className(), ['IdEmpleado' => 'IdEmpleado']);
    }
}
