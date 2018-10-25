<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\CatalogocuentasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalogocuentas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'CodigoCuentas') ?>

    <?= $form->field($model, 'Descripcion') ?>
        <?php
    echo $form->field($model, 'TipoCuenta')->widget(Select2::classname(), [
        'data' => $data = [
            "ACTIVO" => "ACTIVO",
            "PASIVO" => "PASIVO",
            "PATRIMONIO" => "PATRIMONIO",
            "GASTOS" => "GASTOS",
            "INGRESOS" => "INGRESOS",
        ],
        'language' => 'es',
        'options' => ['placeholder' => ' Selecione ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
