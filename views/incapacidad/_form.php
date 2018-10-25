<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Incapacidad */
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
					    <?= $form->field($model, 'IdIncapacidad')->textInput() ?>

    <?= $form->field($model, 'IdEmpleado')->textInput() ?>

    <?= $form->field($model, 'DiasIncapacidad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SalarioDescuento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FechaIncapacidad')->textInput() ?>

    <?= $form->field($model, 'PeriodoIncapacidad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MesIncapacidad')->textInput(['maxlength' => true]) ?>

				 </div>
			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
			    </div>

    			<?php ActiveForm::end(); ?>

       		</div>
    	</div>
</div>
</div>

