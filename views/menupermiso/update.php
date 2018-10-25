<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Menuusuario */

$this->title = 'Actualizar Menu Permiso: ' . $model->idMenuDetalle->DescripcionMenuDetalle;
$this->params['breadcrumbs'][] = ['label' => 'Menu Permiso', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idMenuDetalle->DescripcionMenuDetalle, 'url' => ['view', 'id' => $model->IdMenuUsuario]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="menuusuario-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
