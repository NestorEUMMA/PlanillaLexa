<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "catalogocuentas".
 *
 * @property integer $IdCatalogoCuentas
 * @property string $CodigoCuentas
 * @property string $Descripcion
 * @property string $TipoCuenta
 */
class Catalogocuentas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalogocuentas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CodigoCuentas', 'Descripcion', 'TipoCuenta'], 'required'],
            [['CodigoCuentas', 'Descripcion'], 'string', 'max' => 45],
            [['TipoCuenta'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCatalogoCuentas' => 'Id Catalogo Cuentas',
            'CodigoCuentas' => 'Codigo Cuentas',
            'Descripcion' => 'Descripcion',
            'TipoCuenta' => 'Tipo Cuenta',
        ];
    }
}
