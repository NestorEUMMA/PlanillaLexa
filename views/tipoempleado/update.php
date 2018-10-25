<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tipoempleado */

$this->title = 'Actualizar Tipo Empleado: ' . $model->DescipcionTipoEmpleado;
$this->params['breadcrumbs'][] = ['label' => 'Tipoempleados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DescipcionTipoEmpleado, 'url' => ['view', 'id' => $model->IdTipoEmpleado]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipoempleado-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
