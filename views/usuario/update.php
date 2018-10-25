<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Actualizar Usuario: ' . $model->InicioSesion;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->InicioSesion, 'url' => ['view', 'id' => $model->IdUsuario]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="usuario-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
