<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConstanciadependienteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empleado-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IdEmpleado') ?>

    <?= $form->field($model, 'Nup') ?>

    <?= $form->field($model, 'IdTipoDocumento') ?>

    <?= $form->field($model, 'NumTipoDocumento') ?>

    <?= $form->field($model, 'DuiExpedido') ?>

    <?php // echo $form->field($model, 'DuiEl') ?>

    <?php // echo $form->field($model, 'DuiDe') ?>

    <?php // echo $form->field($model, 'IdInstitucionPre') ?>

    <?php // echo $form->field($model, 'Genero') ?>

    <?php // echo $form->field($model, 'PrimerNomEmpleado') ?>

    <?php // echo $form->field($model, 'SegunNomEmpleado') ?>

    <?php // echo $form->field($model, 'PrimerApellEmpleado') ?>

    <?php // echo $form->field($model, 'SegunApellEmpleado') ?>

    <?php // echo $form->field($model, 'ApellidoCasada') ?>

    <?php // echo $form->field($model, 'ConocidoPor') ?>

    <?php // echo $form->field($model, 'IdTipoEmpleado') ?>

    <?php // echo $form->field($model, 'IdEstadoCivil') ?>

    <?php // echo $form->field($model, 'FNacimiento') ?>

    <?php // echo $form->field($model, 'NIsss') ?>

    <?php // echo $form->field($model, 'MIpsfa') ?>

    <?php // echo $form->field($model, 'Nit') ?>

    <?php // echo $form->field($model, 'SalarioNominal') ?>

    <?php // echo $form->field($model, 'IdPuestoEmpresa') ?>

    <?php // echo $form->field($model, 'Direccion') ?>

    <?php // echo $form->field($model, 'IdDepartamentos') ?>

    <?php // echo $form->field($model, 'IdMunicipios') ?>

    <?php // echo $form->field($model, 'CorreoElectronico') ?>

    <?php // echo $form->field($model, 'TelefonoEmpleado') ?>

    <?php // echo $form->field($model, 'CelularEmpleado') ?>

    <?php // echo $form->field($model, 'CBancaria') ?>

    <?php // echo $form->field($model, 'IdBanco') ?>

    <?php // echo $form->field($model, 'JefeInmediato') ?>

    <?php // echo $form->field($model, 'CasoEmergencia') ?>

    <?php // echo $form->field($model, 'TeleCasoEmergencia') ?>

    <?php // echo $form->field($model, 'Dependiente1') ?>

    <?php // echo $form->field($model, 'FNacimientoDep1') ?>

    <?php // echo $form->field($model, 'Dependiente2') ?>

    <?php // echo $form->field($model, 'FNacimientoDep2') ?>

    <?php // echo $form->field($model, 'Dependiente3') ?>

    <?php // echo $form->field($model, 'FNacimientoDep3') ?>

    <?php // echo $form->field($model, 'Beneficiario') ?>

    <?php // echo $form->field($model, 'DocumentBeneficiario') ?>

    <?php // echo $form->field($model, 'NDocBeneficiario') ?>

    <?php // echo $form->field($model, 'DeducIsssAfp')->checkbox() ?>

    <?php // echo $form->field($model, 'NoDependiente')->checkbox() ?>

    <?php // echo $form->field($model, 'EmpleadoActivo')->checkbox() ?>

    <?php // echo $form->field($model, 'FechaContratacion') ?>

    <?php // echo $form->field($model, 'FechaDespido') ?>

    <?php // echo $form->field($model, 'DeducIsssIpsfa')->checkbox() ?>

    <?php // echo $form->field($model, 'EmpleadoImagen') ?>

    <?php // echo $form->field($model, 'IdDepartamentoEmpresa') ?>

    <?php // echo $form->field($model, 'Profesion') ?>

    <?php // echo $form->field($model, 'OtrosDatos') ?>

    <?php // echo $form->field($model, 'HerramientasTrabajo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
