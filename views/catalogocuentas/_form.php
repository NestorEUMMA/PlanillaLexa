<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Catalogocuentas */
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
					    <?= $form->field($model, 'CodigoCuentas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Descripcion')->textInput(['maxlength' => true]) ?>

            <?php
    echo $form->field($model, 'TipoCuenta')->widget(Select2::classname(), [
        'data' => $data = [
            "SALARIO ADMINISTRACION" => "SALARIO ADMINISTRACION",
            "RETENCIONES LEGALES ISSS" => "RETENCIONES LEGALES ISSS",
            "RETENCIONES LEGALES AFP" => "RETENCIONES LEGALES AFP",
            "RETENCIONES LEGALES IPSFA" => "RETENCIONES LEGALES IPSFA",
            "RETENCIONES LEGALES ISR" => "RETENCIONES LEGALES ISR",
            "ANTICIPOS Y SALARIOS" => "ANTICIPOS Y SALARIOS",
            "SALARIO LIQUIDO" => "SALARIO LIQUIDO",
            "SERVICIOS PROFESIONALES" => "SERVICIOS PROFESIONALES",
            "SALARIO LIQUIDO" => "SALARIO LIQUIDO",
            "SALARIO LIQUIDO" => "SALARIO LIQUIDO",
        ],
        'language' => 'es',
        'options' => ['placeholder' => ' Selecione ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

				 </div>
			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
			    </div>

    			<?php ActiveForm::end(); ?>

       		</div>
    	</div>
</div>
</div>
