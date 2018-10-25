<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "codigoreporteanual".
 *
 * @property string $CodigoIngreso
 * @property string $Descripcion
 *
 * @property Rptrentaanual[] $rptrentaanuals
 */
class Codigoreporteanual extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'codigoreporteanual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CodigoIngreso'], 'required'],
            [['CodigoIngreso'], 'string', 'max' => 11],
            [['Descripcion'], 'string', 'max' => 400],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CodigoIngreso' => 'Codigo Ingreso',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRptrentaanuals()
    {
        return $this->hasMany(Rptrentaanual::className(), ['CodigoIngreso' => 'CodigoIngreso']);
    }
}
