<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Puesto;
use yii\helpers\ArrayHelper;
use kartik\money\MaskMoney;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
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

				    <?= $form->field($model, 'InicioSesion')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Nombres')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Apellidos')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'Correo')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'Clave')->textInput(['maxlength' => true]) ?>

                      <?php
                        echo $form->field($model, 'IdPuesto')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Puesto::find()->all(), 'IdPuesto', 'Descripcion'),
                            'language' => 'es',
                            'options' => ['placeholder' => ' Selecione ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>

                <?php
                echo DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'FechaIngreso',
                    'options' => ['placeholder' => 'Ingrese..'],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy/mm/dd'
                    ]
                ]);
    ?>

 <?= $form->field($model, 'Activo')->checkbox() ?>


				 </div>
			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
			    </div>

    			<?php ActiveForm::end(); ?>

       		</div>
    	</div>
</div>
</div>
