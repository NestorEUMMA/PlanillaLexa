<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Permiso */

$this->title = 'Actualizar Permiso: ' . $model->IdPermisos;
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdPermisos, 'url' => ['view', 'id' => $model->IdPermisos]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="permiso-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
