<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estadocivil".
 *
 * @property integer $IdEstadoCivil
 * @property string $DescripcionEstadoCivil
 */
class Estadocivil extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estadocivil';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DescripcionEstadoCivil'], 'required'],
            [['DescripcionEstadoCivil'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdEstadoCivil' => 'Id Estado Civil',
            'DescripcionEstadoCivil' => 'Descripcion Estado Civil',
        ];
    }
}
