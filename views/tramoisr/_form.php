<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Tramoisr */
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

    <?= $form->field($model, 'TramoDesde')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TramoHasta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TramoAplicarPorcen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TramoExceso')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TramoCuota')->textInput(['maxlength' => true]) ?>

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

				 </div>
			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
			    </div>

    			<?php ActiveForm::end(); ?>

       		</div>
    	</div>
</div>
</div>

