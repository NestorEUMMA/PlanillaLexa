<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banco".
 *
 * @property integer $IdBanco
 * @property string $DescripcionBanco
 */
class Banco extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banco';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DescripcionBanco'], 'required'],
            [['DescripcionBanco'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdBanco' => 'Banco',
            'DescripcionBanco' => 'Nombre',
        ];
    }
}
