<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PuestoempresaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="puestoempresa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IdPuestoEmpresa') ?>

    <?= $form->field($model, 'IdDepartamentoEmpresa') ?>

    <?= $form->field($model, 'DescripcionPuestoEmpresa') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
