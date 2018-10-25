<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tramoisr".
 *
 * @property integer $IdTramoIsr
 * @property string $NumTramo
 * @property string $TramoDesde
 * @property string $TramoHasta
 * @property string $TramoAplicarPorcen
 * @property string $TramoExceso
 * @property string $TramoCuota
 * @property string $TramoFormaPago
 *
 * @property Deduccionempleado[] $deduccionempleados
 */
class Tramoisr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tramoisr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdTramoIsr'], 'required'],
            [['IdTramoIsr'], 'integer'],
            [['TramoDesde', 'TramoHasta', 'TramoAplicarPorcen', 'TramoExceso', 'TramoCuota'], 'number'],
            [['NumTramo', 'TramoFormaPago'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdTramoIsr' => 'Id Tramo Isr',
            'NumTramo' => 'Tramo',
            'TramoDesde' => 'Desde',
            'TramoHasta' => 'Hasta',
            'TramoAplicarPorcen' => 'Porcentaje',
            'TramoExceso' => 'Tramo Exceso',
            'TramoCuota' => 'Tramo Cuota',
            'TramoFormaPago' => 'Forma de Pago',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeduccionempleados()
    {
        return $this->hasMany(Deduccionempleado::className(), ['IdTramoIsr' => 'IdTramoIsr']);
    }
}
