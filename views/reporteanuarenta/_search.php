<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReporteanuarentaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rptrentaanual-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Idrptrentaanual') ?>

    <?= $form->field($model, 'Descripcion') ?>

    <?= $form->field($model, 'IdEmpleado') ?>

    <?= $form->field($model, 'Nit') ?>

    <?= $form->field($model, 'CodigoIngreso') ?>

    <?php // echo $form->field($model, 'MontoDevengado') ?>

    <?php // echo $form->field($model, 'ImpuestoRetenido') ?>

    <?php // echo $form->field($model, 'AguinaldoExento') ?>

    <?php // echo $form->field($model, 'AguinaldoGravado') ?>

    <?php // echo $form->field($model, 'Isss') ?>

    <?php // echo $form->field($model, 'Afp') ?>

    <?php // echo $form->field($model, 'Ipsfa') ?>

    <?php // echo $form->field($model, 'BienestarMagisterial') ?>

    <?php // echo $form->field($model, 'Anio') ?>

    <?php // echo $form->field($model, 'Mes') ?>

    <?php // echo $form->field($model, 'FechaCreacion') ?>

    <?php // echo $form->field($model, 'Quincena') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
