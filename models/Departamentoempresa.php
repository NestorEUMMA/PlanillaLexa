<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "departamentoempresa".
 *
 * @property integer $IdDepartamentoEmpresa
 * @property string $DescripcionDepartamentoEmpresa
 *
 * @property Puestoempresa[] $puestoempresas
 */
class Departamentoempresa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'departamentoempresa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DescripcionDepartamentoEmpresa'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdDepartamentoEmpresa' => 'Id Departamento Empresa',
            'DescripcionDepartamentoEmpresa' => 'Departamento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuestoempresas()
    {
        return $this->hasMany(Puestoempresa::className(), ['IdDepartamentoEmpresa' => 'IdDepartamentoEmpresa']);
    }
}
