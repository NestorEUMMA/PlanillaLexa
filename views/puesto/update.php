<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Puesto */

$this->title = 'Actualizar Puesto: ' . $model->Descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Puestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Descripcion, 'url' => ['view', 'id' => $model->IdPuesto]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="puesto-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
