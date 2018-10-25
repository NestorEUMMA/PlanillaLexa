<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vacaciones */

$this->title = 'Actualizar Vacaciones: ' . $model->FechaVacaciones;
$this->params['breadcrumbs'][] = ['label' => 'Vacaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->FechaVacaciones, 'url' => ['view', 'id' => $model->IdVacaciones]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="vacaciones-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
