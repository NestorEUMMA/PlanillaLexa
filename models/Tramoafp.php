<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tramoafp".
 *
 * @property integer $IdTramoAfp
 * @property string $TramoAfp
 * @property string $TechoAfp
 * @property string $TechoAfpSig
 */
class Tramoafp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tramoafp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdTramoAfp'], 'required'],
            [['IdTramoAfp'], 'integer'],
            [['TramoAfp', 'TechoAfp', 'TechoAfpSig'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTramoAfp' => 'Id Tramo Afp',
            'TramoAfp' => 'Tramo Afp',
            'TechoAfp' => 'Techo Afp',
            'TechoAfpSig' => 'Techo Afp Sig',
        ];
    }
}
