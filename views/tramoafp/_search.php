<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TramoafpSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tramoafp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IdTramoAfp') ?>

    <?= $form->field($model, 'TramoAfp') ?>

    <?= $form->field($model, 'TechoAfp') ?>

    <?= $form->field($model, 'TechoAfpSig') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
