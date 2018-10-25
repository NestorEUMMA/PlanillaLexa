<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parametrosplanilla".
 *
 * @property integer $IdParametroPlanilla
 * @property string $FechaCreacion
 * @property string $MesPlanilla
 * @property string $PeriodoPlanilla
 * @property string $QuincenaPlanilla
 */
class Parametrosplanilla extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parametrosplanilla';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['FechaCreacion', 'MesPlanilla', 'PeriodoPlanilla', 'QuincenaPlanilla'], 'required'],
            [['FechaCreacion', 'MesPlanilla', 'PeriodoPlanilla', 'QuincenaPlanilla'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdParametroPlanilla' => 'Id Parametro Planilla',
            'FechaCreacion' => 'Fecha Creacion',
            'MesPlanilla' => 'Mes Planilla',
            'PeriodoPlanilla' => 'Periodo Planilla',
            'QuincenaPlanilla' => 'Quincena Planilla',
        ];
    }
}
