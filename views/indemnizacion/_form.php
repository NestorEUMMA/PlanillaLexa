<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Empleado;
use yii\helpers\ArrayHelper;
use kartik\money\MaskMoney;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Indemnizacion */
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
    echo $form->field($model, 'IdEmpleado')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Empleado::find()->where(['EmpleadoActivo' => 1])->all(), 'IdEmpleado', 'fullName'),
        'language' => 'es',
        'options' => ['placeholder' => ' Selecione ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'FechaIndemnizacion')->textInput() ?>
                    <?php
        echo '<label class="control-label">Fecha de Indemnizacion</label>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'FechaIndemnizacion',
            'options' => ['placeholder' => 'Ingrese..'],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy/mm/dd'
            ]
        ]);
    ?>

    <?= $form->field($model, 'MesPeriodoIndem')->textInput() ?>

    <?= $form->field($model, 'AnoPeriodoIndem')->textInput() ?>
    
    <?php echo $form->field($model, 'MontoIndemnizacion')->widget(MaskMoney::classname(), [
                'pluginOptions' => [
                    'prefix' => '$ ',
                    'allowNegative' => false
                ]
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

