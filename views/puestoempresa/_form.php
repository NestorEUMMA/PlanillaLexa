<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\DepartamentoEmpresa;
use yii\helpers\ArrayHelper;
use kartik\money\MaskMoney;
use kartik\date\DatePicker;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Puestoempresa */
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
    echo $form->field($model, 'IdDepartamentoEmpresa')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(DepartamentoEmpresa::find()->all(), 'IdDepartamentoEmpresa', 'DescripcionDepartamentoEmpresa'),
        'language' => 'es',
        'options' => ['placeholder' => ' Selecione ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

                        <?= $form->field($model, 'DescripcionPuestoEmpresa')->textInput(['maxlength' => true]) ?>

				 </div>
			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
			    </div>

    			<?php ActiveForm::end(); ?>

       		</div>
    	</div>
</div>
</div>

