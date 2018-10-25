<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comisiones */

$this->title = 'Actualizar Comisiones: ' . $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Comisiones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEmpleado->fullname, 'url' => ['view', 'id' => $model->IdComisiones]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="comisiones-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
