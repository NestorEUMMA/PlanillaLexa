<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresa".
 *
 * @property integer $IdEmpresa
 * @property string $NombreEmpresa
 * @property string $Direccion
 * @property string $IdDepartamentos
 * @property string $IdMunicipios
 * @property string $GiroFiscal
 * @property string $NrcEmpresa
 * @property string $NitEmpresa
 * @property string $Representante
* @property string $NuPatronal
* @property string $ImagenEmpresa
 *
 * @property Departamentos $idDepartamentos
 * @property Municipios $idMunicipios
 */
class Empresa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;

    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NombreEmpresa', 'IdDepartamentos', 'IdMunicipios','Representante', 'NrcEmpresa', 'NitEmpresa','NuPatronal'], 'string', 'max' => 45],
            [['NombreEmpresa', 'IdDepartamentos', 'IdMunicipios','Representante', 'NrcEmpresa', 'NitEmpresa','NuPatronal','GiroFiscal','Direccion'], 'required'],
            [['GiroFiscal'], 'string', 'max' => 100],
            [['Direccion'], 'string', 'max' => 500],
            [['IdDepartamentos'], 'exist', 'skipOnError' => true, 'targetClass' => Departamentos::className(), 'targetAttribute' => ['IdDepartamentos' => 'IdDepartamentos']],
            [['IdMunicipios'], 'exist', 'skipOnError' => true, 'targetClass' => Municipios::className(), 'targetAttribute' => ['IdMunicipios' => 'IdMunicipios']],
            [['file'], 'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            [['ImagenEmpresa'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdEmpresa' => 'Empresa',
            'NombreEmpresa' => 'Empresa',
            'Direccion' => 'Direccion',
            'IdDepartamentos' => 'Departamento',
            'IdMunicipios' => 'Municipio',
            'GiroFiscal' => 'Giro Fiscal',
            'NrcEmpresa' => 'NRC',
            'NitEmpresa' => 'NIT',
            'Representante' => 'Representante Legal',
            'NuPatronal' => 'Numero Patronal',
            'ImagenEmpresa' => 'Logo',
            'file' => 'Logo'
        ];
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


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMunicipios()
    {
        return $this->hasOne(Municipios::className(), ['IdMunicipios' => 'IdMunicipios']);
    }

        public static function getCity($city_id)
    {
        $data=\app\models\Municipios::find()
       ->where(['IdDepartamentos'=>$city_id])
       ->select(['IdMunicipios AS id','DescripcionMunicipios AS name'])->asArray()->all();

            return $data;
        }
}
