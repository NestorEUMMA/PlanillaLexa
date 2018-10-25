<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TramoisrSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tramoisr-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

 <?php
    echo $form->field($model, 'NumTramo')->widget(Select2::classname(), [
        'data' => $data = [
            "Tramo 1" => "Tramo 1",
            "Tramo 2" => "Tramo 2",
            "Tramo 3" => "Tramo 3",
            "Tramo 4" => "Tramo 4",
        ],
        'language' => 'es',
        'options' => ['placeholder' => ' Selecione ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
     <?php
    echo $form->field($model, 'TramoFormaPago')->widget(Select2::classname(), [
        'data' => $data = [
            "MENSUAL" => "MENSUAL",
            "QUINCENAL" => "QUINCENAL",
            "SEMANAL" => "SEMANAL",
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
