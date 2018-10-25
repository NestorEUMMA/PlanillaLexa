<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "configuraciongeneral".
 *
 * @property integer $IdConfiguracion
 * @property string $SalarioMinimo
 * @property boolean $ComisionesConfig
 * @property boolean $HorasExtrasConfig
 * @property boolean $BonosConfig
 * @property boolean $HonorariosConfig
 */
class Configuraciongeneral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configuraciongeneral';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SalarioMinimo'], 'required'],
            [['SalarioMinimo'], 'number'],
            [['ComisionesConfig', 'HorasExtrasConfig', 'BonosConfig', 'HonorariosConfig'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdConfiguracion' => 'Id Configuracion',
            'SalarioMinimo' => 'Salario Minimo',
            'ComisionesConfig' => 'Comisiones ISSS-AFP',
            'HorasExtrasConfig' => 'Horas Extras ISSS-AFP',
            'BonosConfig' => 'Bonos ISSS-AFP',
            'HonorariosConfig' => 'Honorarios ISSS-AFP',
        ];
    }
}
