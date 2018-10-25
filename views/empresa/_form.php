<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use app\models\Empleado;
use app\models\Departamentos;
use app\models\Municipios;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */
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

    <?= $form->field($model, 'NombreEmpresa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Direccion')->textInput(['maxlength' => true]) ?>

    <?php

        $catList=ArrayHelper::map(app\models\Departamentos::find()->all(), 'IdDepartamentos', 'NombreDepartamento' );
        echo $form->field($model, 'IdDepartamentos')->dropDownList($catList, ['id'=>'NombreDepartamento']);

    ?>

  <?php

    echo $form->field($model, 'IdMunicipios')->widget(DepDrop::classname(), [
        'options'=>['id'=>'DescripcionMunicipios'],
        'pluginOptions'=>[
        'depends'=>['NombreDepartamento'],
         'type' => DepDrop::TYPE_SELECT2,
        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
        'placeholder'=>'Seleccione...',
        'url'=>  \yii\helpers\Url::to(['empleado/subcat'])
        ]
        ]);
    ?>

    <?= $form->field($model, 'GiroFiscal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NrcEmpresa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NitEmpresa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NuPatronal')->textInput(['maxlength' => true]) ?>

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

   <?= $form->field($model, 'file')->widget(FileInput::classname(), [
         'options' => ['accept'=>'uploads/*'],
         'pluginOptions'=>[
           'previewFileType' => 'image',
             'allowedFileExtensions'=>['jpg', 'gif', 'png', 'bmp'],
             'showUpload' => true,
             'initialPreview' => [
                 $model->ImagenEmpresa ? Html::img('../'.$model->ImagenEmpresa
                 ) : null, // checks the models to display the preview
             ],
             'initialCaption'=> $model->ImagenEmpresa,
         ],
     ]); ?>

				 </div>
			    <div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
			    </div>

    			<?php ActiveForm::end(); ?>

       		</div>
    	</div>
</div>
</div>
