<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Empleado */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container-fluid">
<div class="col-md-12">
<div class="card">
        <div class="card-header card-header-icon" data-background-color="orange">
            <i class="material-icons">mail_outline</i>
        </div>
        <div class="card-content">
        	<h4 class="card-title"><?= Html::encode($this->title) ?></h4>
			    <?php $form = ActiveForm::begin(); ?>
				<div class="form-group label-floating">
					    <?= $form->field($model, 'Nup')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdTipoDocumento')->textInput() ?>

    <?= $form->field($model, 'NumTipoDocumento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DuiExpedido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DuiEl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DuiDe')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdInstitucionPre')->textInput() ?>

    <?= $form->field($model, 'Genero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PrimerNomEmpleado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SegunNomEmpleado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PrimerApellEmpleado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SegunApellEmpleado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ApellidoCasada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ConocidoPor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdTipoEmpleado')->textInput() ?>

    <?= $form->field($model, 'IdEstadoCivil')->textInput() ?>

    <?= $form->field($model, 'FNacimiento')->textInput() ?>

    <?= $form->field($model, 'NIsss')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MIpsfa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Nit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SalarioNominal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdPuestoEmpresa')->textInput() ?>

    <?= $form->field($model, 'Direccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdDepartamentos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdMunicipios')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CorreoElectronico')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TelefonoEmpleado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CelularEmpleado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CBancaria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdBanco')->textInput() ?>

    <?= $form->field($model, 'JefeInmediato')->textInput() ?>

    <?= $form->field($model, 'CasoEmergencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TeleCasoEmergencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Dependiente1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FNacimientoDep1')->textInput() ?>

    <?= $form->field($model, 'Dependiente2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FNacimientoDep2')->textInput() ?>

    <?= $form->field($model, 'Dependiente3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FNacimientoDep3')->textInput() ?>

    <?= $form->field($model, 'Beneficiario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DocumentBeneficiario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NDocBeneficiario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DeducIsssAfp')->checkbox() ?>

    <?= $form->field($model, 'NoDependiente')->checkbox() ?>

    <?= $form->field($model, 'EmpleadoActivo')->checkbox() ?>

    <?= $form->field($model, 'FechaContratacion')->textInput() ?>

    <?= $form->field($model, 'FechaDespido')->textInput() ?>

    <?= $form->field($model, 'DeducIsssIpsfa')->checkbox() ?>

    <?= $form->field($model, 'EmpleadoImagen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdDepartamentoEmpresa')->textInput() ?>

    <?= $form->field($model, 'Profesion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OtrosDatos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HerramientasTrabajo')->textInput(['maxlength' => true]) ?>

				 </div>
			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
			    </div>

    			<?php ActiveForm::end(); ?>

       		</div>
    	</div>
</div>
</div>

