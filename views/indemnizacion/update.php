<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Indemnizacion */

$this->title = 'Actualizar Indemnizacion: ' . $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Indemnizacion', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEmpleado->fullname, 'url' => ['view', 'id' => $model->IdIndemnizacion]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="indemnizacion-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
