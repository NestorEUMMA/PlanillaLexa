<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Usuario;
use app\models\Menu;
use app\models\MenuDetalle;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Menuusuariosearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menuusuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


         <?php
    echo $form->field($model, 'IdMenu')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Menu::find()->where([
                '>','IdMenu', 2])->all(), 'IdMenu', 'DescripcionMenu'),
        'language' => 'es',
        'options' => ['placeholder' => ' Selecione ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

         <?php
    echo $form->field($model, 'IdMenuDetalle')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(MenuDetalle::find()->where([
                '>','IdMenu', 2])->all(), 'IdMenuDetalle', 'DescripcionMenuDetalle'),
        'language' => 'es',
        'options' => ['placeholder' => ' Selecione ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
       <!--  <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?> -->
    </div>

    <?php ActiveForm::end(); ?>

</div>
