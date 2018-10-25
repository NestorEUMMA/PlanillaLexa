<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipoempleado".
 *
 * @property integer $IdTipoEmpleado
 * @property string $DescipcionTipoEmpleado
 *
 * @property Empleado[] $empleados
 */
class Tipoempleado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipoempleado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DescipcionTipoEmpleado'], 'required'],
            [['DescipcionTipoEmpleado'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTipoEmpleado' => 'Id Tipo Empleado',
            'DescipcionTipoEmpleado' => 'Tipo de Empleado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleados()
    {
        return $this->hasMany(Empleado::className(), ['IdTipoEmpleado' => 'IdTipoEmpleado']);
    }
}
