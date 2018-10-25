<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipios".
 *
 * @property string $IdMunicipios
 * @property string $DescripcionMunicipios
 * @property string $IdPadre
 * @property integer $Nivel
 * @property string $Jerarquia
 * @property string $IdDepartamentos
 *
 * @property Departamentos $departamentos
 * @property Empleado[] $empleados
 * @property Empresa[] $empresas
 */
class Municipios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'municipios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMunicipios', 'DescripcionMunicipios', 'Nivel', 'Jerarquia', 'IdDepartamentos'], 'required'],
            [['Nivel'], 'integer'],
            [['IdMunicipios', 'DescripcionMunicipios', 'IdPadre', 'Jerarquia', 'IdDepartamentos'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMunicipios' => 'Id Municipios',
            'DescripcionMunicipios' => 'Descripcion Municipios',
            'IdPadre' => 'Id Padre',
            'Nivel' => 'Nivel',
            'Jerarquia' => 'Jerarquia',
            'IdDepartamentos' => 'Id Departamentos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamentos()
    {
        return $this->hasOne(Departamentos::className(), ['IdDepartamentos' => 'IdDepartamentos']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleados()
    {
        return $this->hasMany(Empleado::className(), ['IdMunicipios' => 'IdMunicipios']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Empresa::className(), ['IdMunicipios' => 'IdMunicipios']);
    }

    // public static function getCity($city_id) {
    //     $data=\app\models\Municipios::find()
    //    ->where(['IdDepartamentos'=>$city_id])
    //    ->select(['IdMunicipios AS id','DescripcionMunicipios AS name'])->asArray()->all();
    //         return $data;
    //     }
}
