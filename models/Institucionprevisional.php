<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "institucionprevisional".
 *
 * @property integer $IdInstitucionPre
 * @property string $DescripcionInstitucion
 */
class Institucionprevisional extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'institucionprevisional';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DescripcionInstitucion'], 'required'],
            [['DescripcionInstitucion'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdInstitucionPre' => 'Id Institucion Pre',
            'DescripcionInstitucion' => 'Descripcion Institucion',
        ];
    }
}
