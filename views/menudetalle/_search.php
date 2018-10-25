<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MenudetalleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menudetalle-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IdMenuDetalle') ?>

    <?= $form->field($model, 'IdMenu') ?>

    <?= $form->field($model, 'DescripcionMenuDetalle') ?>

    <?= $form->field($model, 'Url') ?>

    <?= $form->field($model, 'Icono') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
