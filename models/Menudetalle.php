<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menudetalle".
 *
 * @property integer $IdMenuDetalle
 * @property integer $IdMenu
 * @property string $DescripcionMenuDetalle
 * @property string $Url
 * @property string $Icono
 *
 * @property Menu $idMenu
 */
class Menudetalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menudetalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdMenu'], 'required'],
            [['IdMenu'], 'integer'],
            [['DescripcionMenuDetalle', 'Url'], 'string', 'max' => 400],
            [['Icono'], 'string', 'max' => 200],
            [['IdMenu'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['IdMenu' => 'IdMenu']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdMenuDetalle' => 'Menu Detalle',
            'IdMenu' => 'Menu',
            'DescripcionMenuDetalle' => 'Descripcion',
            'Url' => 'Url',
            'Icono' => 'Icono',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMenu()
    {
        return $this->hasOne(Menu::className(), ['IdMenu' => 'IdMenu']);
    }
}
