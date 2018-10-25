<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConfiguraciongeneralSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="configuraciongeneral-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IdConfiguracion') ?>

    <?= $form->field($model, 'SalarioMinimo') ?>

    <?= $form->field($model, 'ComisionesConfig')->checkbox() ?>

    <?= $form->field($model, 'HorasExtrasConfig')->checkbox() ?>

    <?= $form->field($model, 'BonosConfig')->checkbox() ?>

    <?php // echo $form->field($model, 'Honorarios')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
