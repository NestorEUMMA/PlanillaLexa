<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PermisosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IdUsuario') ?>

    <?= $form->field($model, 'InicioSesion') ?>

    <?= $form->field($model, 'Nombres') ?>

    <?= $form->field($model, 'Apellidos') ?>

    <?= $form->field($model, 'Correo') ?>

    <?php // echo $form->field($model, 'Clave') ?>

    <?php // echo $form->field($model, 'Activo') ?>

    <?php // echo $form->field($model, 'IdPuesto') ?>

    <?php // echo $form->field($model, 'FechaIngreso') ?>

    <?php // echo $form->field($model, 'LexaAdmin') ?>

    <?php // echo $form->field($model, 'ImagenUsuario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
