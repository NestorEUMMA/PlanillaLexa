<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empleado".
 *
 * @property integer $IdEmpleado
 * @property string $Nup
 * @property integer $IdTipoDocumento
 * @property string $NumTipoDocumento
 * @property integer $IdInstitucionPre
 * @property string $Genero
 * @property string $PrimerNomEmpleado
 * @property string $SegunNomEmpleado
 * @property string $PrimerApellEmpleado
 * @property string $SegunApellEmpleado
 * @property string $ApellidoCasada
 * @property string $ConocidoPor
 * @property integer $IdTipoEmpleado
 * @property integer $IdEstadoCivil
 * @property string $FNacimiento
 * @property string $NIsss
 * @property string $MIpsfa
 * @property string $Nit
 * @property string $SalarioNominal
 * @property integer $IdPuestoEmpresa
 * @property string $Direccion
 * @property string $IdDepartamentos
 * @property string $IdMunicipios
 * @property string $CorreoElectronico
 * @property string $TelefonoEmpleado
 * @property string $CelularEmpleado
 * @property string $CBancaria
 * @property integer $IdBanco
 * @property string $EmpleadoImagen
 * @property integer $JefeInmediato
 * @property string $CasoEmergencia
 * @property string $TeleCasoEmergencia
 * @property string $Dependiente1
 * @property string $FNacimientoDep1
 * @property string $Dependiente2
 * @property string $FNacimientoDep2
 * @property string $Dependiente3
 * @property string $FNacimientoDep3
 * @property string $Beneficiario
 * @property string $DocumentBeneficiario
 * @property string $NDocBeneficiario
 * @property boolean $DeducIsssAfp
 * @property boolean $DeducIsssIpsfa
 * @property boolean $NoDependiente
 * @property boolean $Pensionado
 * @property boolean $EmpleadoActivo
 * @property string $FechaContratacion
 * @property string $FechaDespido
 * @property string $Profesion
 * @property string $DuiExpedido
 * @property string $DuiEl
 * @property string $DuiDe
 * @property string $OtrosDatos
 * @property string $HerramientasTrabajo
 *
 * @property Deduccionempleado[] $deduccionempleados
 * @property Banco $idBanco
 * @property Departamentos $idDepartamentos
 * @property Estadocivil $idEstadoCivil
 * @property Institucionprevisional $idInstitucionPre
 * @property Municipios $idMunicipios
 * @property Departamentoempresa $idDepartamentoEmpresa
 * @property Puestoempresa $idPuestoEmpresa
 * @property Tipodocumento $idTipoDocumento
 * @property Tipoempleado $idTipoEmpleado
 */
class Empleado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;


    public static function tableName()
    {
        return 'empleado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdTipoDocumento', 'IdInstitucionPre', 'IdTipoEmpleado', 'IdEstadoCivil', 'IdPuestoEmpresa','IdDepartamentoEmpresa','IdBanco', 'JefeInmediato'], 'integer'],
            [['PrimerNomEmpleado', 'PrimerApellEmpleado', 'IdTipoEmpleado', 'IdEstadoCivil', 'IdDepartamentos', 'IdMunicipios', 'NumTipoDocumento', 'IdTipoDocumento', 'Genero', 'SalarioNominal','Profesion','FNacimiento','FechaContratacion','Nit','Nup'], 'required'],
            [['FNacimiento'], 'safe'],
            [['SalarioNominal'], 'number'],
            [['DeducIsssAfp', 'DeducIsssIpsfa', 'NoDependiente', 'EmpleadoActivo','Pensionado'], 'boolean'],
            [['Nup', 'NumTipoDocumento', 'Genero', 'PrimerNomEmpleado', 'SegunNomEmpleado', 'PrimerApellEmpleado', 'SegunApellEmpleado', 'ApellidoCasada', 'ConocidoPor', 'NIsss', 'MIpsfa', 'Direccion', 'IdDepartamentos', 'IdMunicipios', 'CorreoElectronico', 'TelefonoEmpleado', 'CelularEmpleado', 'CBancaria', 'CasoEmergencia', 'TeleCasoEmergencia', 'DocumentBeneficiario', 'NDocBeneficiario', 'FechaContratacion', 'FechaDespido','DuiEl','DuiDe','FNacimientoDep1','FNacimientoDep2','FNacimientoDep3'], 'string', 'max' => 45],
            [['Nit'], 'string', 'max' => 25],
            [['Profesion','DuiExpedido'], 'string', 'max' => 100],
            [['file'], 'file','skipOnEmpty' => true,  'extensions' => 'png, jpg, jpeg'],

            [['EmpleadoImagen'], 'string', 'max' => 200],
            [['OtrosDatos','HerramientasTrabajo'], 'string', 'max' => 500],
            [['Dependiente1', 'Dependiente2', 'Dependiente3', 'Beneficiario'], 'string', 'max' => 100],
            [['IdBanco'], 'exist', 'skipOnError' => true, 'targetClass' => Banco::className(), 'targetAttribute' => ['IdBanco' => 'IdBanco']],
            [['IdDepartamentos'], 'exist', 'skipOnError' => true, 'targetClass' => Departamentos::className(), 'targetAttribute' => ['IdDepartamentos' => 'IdDepartamentos']],
            [['IdEstadoCivil'], 'exist', 'skipOnError' => true, 'targetClass' => Estadocivil::className(), 'targetAttribute' => ['IdEstadoCivil' => 'IdEstadoCivil']],
            [['IdInstitucionPre'], 'exist', 'skipOnError' => true, 'targetClass' => Institucionprevisional::className(), 'targetAttribute' => ['IdInstitucionPre' => 'IdInstitucionPre']],
            [['IdMunicipios'], 'exist', 'skipOnError' => true, 'targetClass' => Municipios::className(), 'targetAttribute' => ['IdMunicipios' => 'IdMunicipios']],
            [['IdPuestoEmpresa'], 'exist', 'skipOnError' => true, 'targetClass' => Puestoempresa::className(), 'targetAttribute' => ['IdPuestoEmpresa' => 'IdPuestoEmpresa']],
            [['IdDepartamentoEmpresa'], 'exist', 'skipOnError' => true, 'targetClass' => Departamentoempresa::className(), 'targetAttribute' => ['IdDepartamentoEmpresa' => 'IdDepartamentoEmpresa']],
            [['IdTipoDocumento'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodocumento::className(), 'targetAttribute' => ['IdTipoDocumento' => 'IdTipoDocumento']],
            [['IdTipoEmpleado'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoempleado::className(), 'targetAttribute' => ['IdTipoEmpleado' => 'IdTipoEmpleado']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdEmpleado' => 'Empleado',
            'Nup' => 'NUP',
            'IdTipoDocumento' => 'Tipo de Documento',
            'NumTipoDocumento' => 'Numero de Documento',
            'IdInstitucionPre' => 'Institucion Previsional',
            'Genero' => 'Genero',
            'PrimerNomEmpleado' => 'Primer Nombre',
            'SegunNomEmpleado' => 'Segundo Nombre',
            'PrimerApellEmpleado' => 'Primer Apellido',
            'SegunApellEmpleado' => 'Segundo Apellido',
            'ApellidoCasada' => 'Apellido de Casada',
            'ConocidoPor' => 'Conocido Por',
            'IdTipoEmpleado' => 'Tipo de Empleado',
            'IdEstadoCivil' => 'Estado Civil',
            'FNacimiento' => 'Fecha de Nacimiento',
            'NIsss' => 'N° ISSS',
            'MIpsfa' => 'Nº Afiliacion',
            'Nit' => 'NIT',
            'SalarioNominal' => 'Salario Nominal',
            'IdPuestoEmpresa' => 'Puesto en Empresa',
            'Direccion' => 'Direccion',
            'IdDepartamentos' => 'Departamentos',
            'IdMunicipios' => 'Municipios',
            'CorreoElectronico' => 'Correo Electronico',
            'TelefonoEmpleado' => 'Telefono del Empleado',
            'CelularEmpleado' => 'Celular del Empleado',
            'CBancaria' => 'Cuenta Bancaria',
            'IdBanco' => 'Banco',
            'JefeInmediato' => 'Jefe Inmediato',
            'CasoEmergencia' => 'En caso de Emergencia',
            'TeleCasoEmergencia' => 'Telefono de Emergencia',
            'Dependiente1' => 'Nombre Dependiente 1',
            'FNacimientoDep1' => 'Fecha Nacimiento',
            'FNacimientoDep2' => 'Fecha Nacimiento',
            'FNacimientoDep3' => 'Fecha Nacimiento',
            'Dependiente2' => 'Nombre Dependiente 2',
            'Dependiente3' => 'Nombre Dependiente 3',
            'Beneficiario' => 'Beneficiario',
            'DocumentBeneficiario' => 'Documento del Beneficiario',
            'NDocBeneficiario' => 'N° Documento',
            'DeducIsssAfp' => 'ISSS - AFP',
            'Pensionado' => 'Pensionado',
            'NoDependiente' => 'No Dependiente',
            'EmpleadoActivo' => 'Empleado Activo',
            'FechaContratacion' => 'Fecha Contratacion',
            'FechaDespido' => 'Fecha Despido',
            'DeducIsssIpsfa' => 'ISSS - IPSFA',
            'fullName' => Yii::t('app', 'Full Name'),
            'fullName' => 'Empleado',
            'idPuestoEmpresa.DescripcionPuestoEmpresa' => 'Puesto Empresa',
             'idTipoDocumento.DescripcionTipoDocumento'  => 'Tipo de Documento',
             'idInstitucionPre.DescripcionInstitucion'  => 'Institucion Previsional',
             'EmpleadoImagen' => 'Foto',
             'file' => 'Foto',
             'IdDepartamentoEmpresa' => 'Departamento Empresarial',
             'Profesion' => 'Profesion',
             'DuiExpedido' => 'Expedido en',
             'DuiEl' => 'El',
             'DuiDe' => 'De',
             'OtrosDatos' => 'Otros Datos',
             'HerramientasTrabajo' => 'Herramientas de Trabajo',
             'idDepartamentos.NombreDepartamento' => 'Departamento',
             'idMunicipios.DescripcionMunicipios' => 'Municipio'

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeduccionempleados()
    {
        return $this->hasMany(Deduccionempleado::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBanco()
    {
        return $this->hasOne(Banco::className(), ['IdBanco' => 'IdBanco']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDepartamentos()
    {
        return $this->hasOne(Departamentos::className(), ['IdDepartamentos' => 'IdDepartamentos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstadoCivil()
    {
        return $this->hasOne(Estadocivil::className(), ['IdEstadoCivil' => 'IdEstadoCivil']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdInstitucionPre()
    {
        return $this->hasOne(Institucionprevisional::className(), ['IdInstitucionPre' => 'IdInstitucionPre']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMunicipios()
    {
        return $this->hasOne(Municipios::className(), ['IdMunicipios' => 'IdMunicipios']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getIdPuestoEmpresa()
    {
        return $this->hasOne(Puestoempresa::className(), ['IdPuestoEmpresa' => 'IdPuestoEmpresa']);
    }

        public function getIdDepartamentoEmpresa()
    {
        return $this->hasOne(Departamentoempresa::className(), ['IdDepartamentoEmpresa' => 'IdDepartamentoEmpresa']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoDocumento()
    {
        return $this->hasOne(Tipodocumento::className(), ['IdTipoDocumento' => 'IdTipoDocumento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipoEmpleado()
    {
        return $this->hasOne(Tipoempleado::className(), ['IdTipoEmpleado' => 'IdTipoEmpleado']);
    }


    public function getFullName()
    {
            return $this->PrimerNomEmpleado.' '.$this->SegunNomEmpleado.' '.$this->PrimerApellEmpleado.' '.$this->SegunApellEmpleado;
    }


    public static function getCity($city_id)
    {
        $data=\app\models\Municipios::find()
       ->where(['IdDepartamentos'=>$city_id])
       ->select(['IdMunicipios AS id','DescripcionMunicipios AS name'])->asArray()->all();

            return $data;
        }

    public static function getPuesto($city_id)
    {
        $data=\app\models\Puestoempresa::find()
       ->where(['IdDepartamentoEmpresa'=>$city_id])
       ->select(['IdPuestoEmpresa AS id','DescripcionPuestoEmpresa AS name'])->asArray()->all();

            return $data;
        }

        public function upload()
        {
            if ($this->validate()) {
                $this->file->saveAs('uploads/' . $this->fullName->baseName . '.' . $this->file->extension);
                return true;
            } else {
                return false;
            }
        }
}
