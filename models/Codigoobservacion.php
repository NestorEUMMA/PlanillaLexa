<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "codigoobservacion".
 *
 * @property integer $IdCodigoObservacion
 * @property string $Codigo
 * @property string $DescripcionCodigo
 */
class Codigoobservacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'codigoobservacion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Codigo', 'DescripcionCodigo'], 'required'],
            [['Codigo', 'DescripcionCodigo'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCodigoObservacion' => 'Id Codigo Observacion',
            'Codigo' => 'Codigo',
            'DescripcionCodigo' => 'Descripcion',
        ];
    }
}
