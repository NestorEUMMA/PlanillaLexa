<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "codigosepp".
 *
 * @property string $CodigoSepp
 * @property string $Descripcion
 *
 * @property Rptsepp[] $rptsepps
 */
class Codigosepp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'codigosepp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CodigoSepp', 'Descripcion'], 'required'],
            [['CodigoSepp'], 'string', 'max' => 2],
            [['Descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CodigoSepp' => 'Codigo Sepp',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRptsepps()
    {
        return $this->hasMany(Rptsepp::className(), ['CodigoSepp' => 'CodigoSepp']);
    }
}
