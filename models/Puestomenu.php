<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "puestomenu".
 *
 * @property integer $IdPuestoMenu
 * @property integer $IdPuesto
 * @property integer $IdMenu
 *
 * @property Menu $idMenu
 * @property Puesto $idPuesto
 */
class Puestomenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'puestomenu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdPuesto', 'IdMenu'], 'required'],
            [['IdPuesto', 'IdMenu'], 'integer'],
            [['IdMenu'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['IdMenu' => 'IdMenu']],
            [['IdPuesto'], 'exist', 'skipOnError' => true, 'targetClass' => Puesto::className(), 'targetAttribute' => ['IdPuesto' => 'IdPuesto']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdPuestoMenu' => 'Id Puesto Menu',
            'IdPuesto' => 'Id Puesto',
            'IdMenu' => 'Id Menu',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMenu()
    {
        return $this->hasOne(Menu::className(), ['IdMenu' => 'IdMenu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPuesto()
    {
        return $this->hasOne(Puesto::className(), ['IdPuesto' => 'IdPuesto']);
    }
}
