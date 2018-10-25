<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Menuusuario */

$this->title = 'Actualizar Menu Usuario: ' . $model->idMenu->DescripcionMenu;
$this->params['breadcrumbs'][] = ['label' => 'Menuusuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idMenu->DescripcionMenu, 'url' => ['view', 'id' => $model->IdMenuUsuario]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="menuusuario-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
