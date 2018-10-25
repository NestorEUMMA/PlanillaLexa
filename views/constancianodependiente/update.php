<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Empleado */

$this->title = 'Actualizar Empleado: ' . $model->IdEmpleado;
$this->params['breadcrumbs'][] = ['label' => 'Empleados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdEmpleado, 'url' => ['view', 'id' => $model->IdEmpleado]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="empleado-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
