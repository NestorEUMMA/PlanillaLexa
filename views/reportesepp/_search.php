<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReporteseppSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rptsepp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IdReporteSepp') ?>

    <?= $form->field($model, 'IdEmpleado') ?>

    <?= $form->field($model, 'CodigoSepp') ?>

    <?= $form->field($model, 'PlanillaCodigoObservacion') ?>

    <?= $form->field($model, 'PlanillaIngresoBaseCotizacion') ?>

    <?php // echo $form->field($model, 'PlanillaHorasJornadaLaboral') ?>

    <?php // echo $form->field($model, 'PlanillaDiasCotizados') ?>

    <?php // echo $form->field($model, 'PlanillaCotizacionVoluntariaAfiliado') ?>

    <?php // echo $form->field($model, 'PlanillaCotizacionVoluntariaEmpleador') ?>

    <?php // echo $form->field($model, 'Nup') ?>

    <?php // echo $form->field($model, 'InstitucionPrevisional') ?>

    <?php // echo $form->field($model, 'PrimerNombre') ?>

    <?php // echo $form->field($model, 'SegundoNombre') ?>

    <?php // echo $form->field($model, 'PrimerApellido') ?>

    <?php // echo $form->field($model, 'SegundoApellido') ?>

    <?php // echo $form->field($model, 'ApellidoCasada') ?>

    <?php // echo $form->field($model, 'TipoDocumento') ?>

    <?php // echo $form->field($model, 'NumeroDocumento') ?>

    <?php // echo $form->field($model, 'Periodo') ?>

    <?php // echo $form->field($model, 'Mes') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
