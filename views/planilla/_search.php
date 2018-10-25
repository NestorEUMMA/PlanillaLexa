<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PlanillaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planilla-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IdPlanilla') ?>

    <?= $form->field($model, 'IdEmpleado') ?>

    <?= $form->field($model, 'Honorario') ?>

    <?= $form->field($model, 'Comision') ?>

    <?= $form->field($model, 'Bono') ?>

    <?php // echo $form->field($model, 'Anticipos') ?>

    <?php // echo $form->field($model, 'HorasExtras') ?>

    <?php // echo $form->field($model, 'Vacaciones') ?>

    <?php // echo $form->field($model, 'MesPlanilla') ?>

    <?php // echo $form->field($model, 'AnioPlanilla') ?>

    <?php // echo $form->field($model, 'FechaTransaccion') ?>

    <?php // echo $form->field($model, 'ISRPlanilla') ?>

    <?php // echo $form->field($model, 'AFPPlanilla') ?>

    <?php // echo $form->field($model, 'ISSSPlanilla') ?>

    <?php // echo $form->field($model, 'Incapacidades') ?>

    <?php // echo $form->field($model, 'DiasIncapacidad') ?>

    <?php // echo $form->field($model, 'Permisos') ?>

    <?php // echo $form->field($model, 'DiasPermiso') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
