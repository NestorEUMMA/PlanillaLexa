<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Empleado;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\HorasextrasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="horasextras-search">

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

    <?php
    echo $form->field($model, 'MesPeriodoHorasExt')->widget(Select2::classname(), [
        'data' => $data = [
            "Enero" => "Enero",
            "Febrero" => "Febrero",
            "Marzo" => "Marzo",
            "Abril" => "Abril",
            "Mayo" => "Mayo",
            "Junio" => "Junio",
            "Julio" => "Julio",
            "Agosto" => "Agosto",
            "Septiembre" => "Septiembre",
            "Octubre" => "Octubre",
            "Noviembre" => "Noviembre",
            "Diciembre" => "Diciembre",
        ],
        'language' => 'es',
        'options' => ['placeholder' => ' Selecione ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

        <?php
    echo $form->field($model, 'AnoPeriodoHorasExt')->widget(Select2::classname(), [
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


    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
