<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Codigoreporteanual */

$this->title = 'Actualizar Codigo: ' . $model->CodigoIngreso;
$this->params['breadcrumbs'][] = ['label' => 'Codigo', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CodigoIngreso, 'url' => ['view', 'id' => $model->CodigoIngreso]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="codigoreporteanual-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
