<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tramoipsfa".
 *
 * @property integer $IdTramoIpsfa
 * @property string $TramoIpsfa
 * @property string $TechoIpsfa
 * @property string $TechoIpsfaSig
 */
class Tramoipsfa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tramoipsfa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TramoIpsfa', 'TechoIpsfa', 'TechoIpsfaSig'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTramoIpsfa' => 'Id Tramo Ipsfa',
            'TramoIpsfa' => 'Tramo Ipsfa',
            'TechoIpsfa' => 'Techo Ipsfa',
            'TechoIpsfaSig' => 'Techo Ipsfa Sig',
        ];
    }
}
