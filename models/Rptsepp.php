<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rptsepp".
 *
 * @property integer $IdReporteSepp
 * @property integer $IdEmpleado
 * @property string $CodigoSepp
 * @property string $PlanillaCodigoObservacion
 * @property string $PlanillaIngresoBaseCotizacion
 * @property string $PlanillaHorasJornadaLaboral
 * @property string $PlanillaDiasCotizados
 * @property string $PlanillaCotizacionVoluntariaAfiliado
 * @property string $PlanillaCotizacionVoluntariaEmpleador
 * @property string $Nup
 * @property string $InstitucionPrevisional
 * @property string $PrimerNombre
 * @property string $SegundoNombre
 * @property string $PrimerApellido
 * @property string $SegundoApellido
 * @property string $ApellidoCasada
 * @property string $TipoDocumento
 * @property string $NumeroDocumento
 * @property string $Periodo
 * @property string $Mes
 *
 * @property Codigosepp $codigoSepp
 */
class Rptsepp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rptsepp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEmpleado'], 'integer'],
            [['CodigoSepp'], 'string', 'max' => 2],
            [['PlanillaCodigoObservacion', 'PlanillaIngresoBaseCotizacion', 'PlanillaHorasJornadaLaboral', 'PlanillaDiasCotizados', 'PlanillaCotizacionVoluntariaAfiliado', 'PlanillaCotizacionVoluntariaEmpleador', 'Nup', 'InstitucionPrevisional', 'PrimerNombre', 'SegundoNombre', 'PrimerApellido', 'SegundoApellido', 'ApellidoCasada', 'TipoDocumento', 'NumeroDocumento', 'Periodo', 'Mes'], 'string', 'max' => 45],
            [['CodigoSepp'], 'exist', 'skipOnError' => true, 'targetClass' => Codigosepp::className(), 'targetAttribute' => ['CodigoSepp' => 'CodigoSepp']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdReporteSepp' => 'Id Reporte Sepp',
            'IdEmpleado' => 'Id Empleado',
            'CodigoSepp' => 'Codigo Sepp',
            'PlanillaCodigoObservacion' => 'Planilla Codigo Observacion',
            'PlanillaIngresoBaseCotizacion' => 'Planilla Ingreso Base Cotizacion',
            'PlanillaHorasJornadaLaboral' => 'Planilla Horas Jornada Laboral',
            'PlanillaDiasCotizados' => 'Planilla Dias Cotizados',
            'PlanillaCotizacionVoluntariaAfiliado' => 'Planilla Cotizacion Voluntaria Afiliado',
            'PlanillaCotizacionVoluntariaEmpleador' => 'Planilla Cotizacion Voluntaria Empleador',
            'Nup' => 'Nup',
            'InstitucionPrevisional' => 'Institucion Previsional',
            'PrimerNombre' => 'Primer Nombre',
            'SegundoNombre' => 'Segundo Nombre',
            'PrimerApellido' => 'Primer Apellido',
            'SegundoApellido' => 'Segundo Apellido',
            'ApellidoCasada' => 'Apellido Casada',
            'TipoDocumento' => 'Tipo Documento',
            'NumeroDocumento' => 'Numero Documento',
            'Periodo' => 'Periodo',
            'Mes' => 'Mes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodigoSepp()
    {
        return $this->hasOne(Codigosepp::className(), ['CodigoSepp' => 'CodigoSepp']);
    }
}
