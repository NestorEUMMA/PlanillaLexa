<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Deduccionempleado */

$this->title = 'Actualizar Deduccionempleado: ' . $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Deduccionempleados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEmpleado->fullname, 'url' => ['view', 'id' => $model->IdDeduccionEmpleado]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="deduccionempleado-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
