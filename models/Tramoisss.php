<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tramoisss".
 *
 * @property integer $IdTramoIsss
 * @property string $TramoIsss
 * @property string $TechoIsss
 * @property string $TechoSig
 *
 * @property Deduccionempleado[] $deduccionempleados
 */
class Tramoisss extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tramoisss';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TramoIsss', 'TechoIsss', 'TechoSig'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTramoIsss' => 'Id Tramo Isss',
            'TramoIsss' => 'Tramo',
            'TechoIsss' => 'Techo',
            'TechoSig' => 'Techo Sig',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeduccionempleados()
    {
        return $this->hasMany(Deduccionempleado::className(), ['IdTramoIsss' => 'IdTramoIsss']);
    }
}
