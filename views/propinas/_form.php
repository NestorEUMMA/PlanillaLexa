<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Empleado;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Propinas */
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
       </br>
         <?php

             echo DatePicker::widget([
                 'model' => $model,
                 'attribute' => 'Fecha',
                 'options' => ['placeholder' => 'Ingrese..'],
                 'pluginOptions' => [
                     'autoclose' => true,
                     'format' => 'yyyy/mm/dd'
                 ]
             ]);


             ?>
</br>
           <?php
             echo $form->field($model, 'PropinaPeriodo')->widget(Select2::classname(), [
             'data' => $data = [
                 "2018" => "2018",
                 "2019" => "2019",
                 "2020" => "2020",
                 "2021" => "2021",
                 "2022" => "2022",
                 "2023" => "2023",
                 "2024" => "2024",
                 "2025" => "2025",
             ],
             'language' => 'es',
             'options' => ['placeholder' => ' Selecione ...'],
             'pluginOptions' => [
                 'allowClear' => true
             ],
         ]);
         ?>

         <?php
           echo $form->field($model, 'PropinaMes')->widget(Select2::classname(), [
           'data' => $data = [
               "ENERO" => "ENERO",
               "FEBRERO" => "FEBRERO",
               "MARZO" => "MARZO",
               "ABRIL" => "ABRIL",
               "MAYO" => "MAYO",
               "JUNIO" => "JUNIO",
               "JULIO" => "JULIO",
               "AGOSTO" => "AGOSTO",
               "SEPTIEMBRE" => "SEPTIEMBRE",
               "OCTUBRE" => "OCTUBRE",
               "NOVIEMBRE" => "NOVIEMBRE",
               "DICIEMBRE" => "DICIEMBRE",
           ],
           'language' => 'es',
           'options' => ['placeholder' => ' Selecione ...'],
           'pluginOptions' => [
               'allowClear' => true
           ],
       ]);
       ?>

    <?= $form->field($model, 'MontoPropina')->textInput(['maxlength' => true]) ?>

				 </div>
			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
			    </div>

    			<?php ActiveForm::end(); ?>

       		</div>
    	</div>
</div>
</div>
