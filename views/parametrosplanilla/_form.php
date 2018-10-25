<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Parametrosplanilla */
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
					    <?= $form->field($model, 'FechaCreacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MesPlanilla')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PeriodoPlanilla')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QuincenaPlanilla')->textInput(['maxlength' => true]) ?>

				 </div>
			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
			    </div>

    			<?php ActiveForm::end(); ?>

       		</div>
    	</div>
</div>
</div>

