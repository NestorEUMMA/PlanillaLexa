<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Departamentos;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\DepartamentosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="departamentos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'NombreDepartamento') ?>

               <?php
    echo $form->field($model, 'IdDepartamentos')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Departamentos::find()->all(), 'IdDepartamentos', 'NombreDepartamento'),
        'language' => 'es',
        'options' => ['placeholder' => ' Selecione ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>


    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
