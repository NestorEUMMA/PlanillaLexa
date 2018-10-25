<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parametros".
 *
 * @property integer $IdParametro
 * @property string $ISRParametro
 *
 * @property Comisiones[] $comisiones
 * @property Honorario[] $honorarios
 */
class Parametros extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parametros';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ISRParametro'], 'required'],
            [['ISRParametro'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdParametro' => 'Id Parametro',
            'ISRParametro' => 'ISR',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComisiones()
    {
        return $this->hasMany(Comisiones::className(), ['IdParametro' => 'IdParametro']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHonorarios()
    {
        return $this->hasMany(Honorario::className(), ['IdParametro' => 'IdParametro']);
    }
}
