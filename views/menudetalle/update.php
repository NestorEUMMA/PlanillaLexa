<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Menudetalle */

$this->title = 'Actualizar Menu Detalle: ' . $model->DescripcionMenuDetalle;
$this->params['breadcrumbs'][] = ['label' => 'Menu Detalle', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DescripcionMenuDetalle, 'url' => ['view', 'id' => $model->IdMenuDetalle]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="menudetalle-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
