<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipodocumento".
 *
 * @property integer $IdTipoDocumento
 * @property string $DescripcionTipoDocumento
 */
class Tipodocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipodocumento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DescripcionTipoDocumento'], 'required'],
            [['DescripcionTipoDocumento'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTipoDocumento' => 'Id Tipo Documento',
            'DescripcionTipoDocumento' => ' Documento',
        ];
    }
}
