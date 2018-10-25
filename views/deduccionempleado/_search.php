<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Empleado;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\DeduccionempleadoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deduccionempleado-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


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


    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
