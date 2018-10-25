<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */

$this->title = 'Actualizar Menu: ' . $model->DescripcionMenu;
$this->params['breadcrumbs'][] = ['label' => 'Menu', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DescripcionMenu, 'url' => ['view', 'id' => $model->IdMenu]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="menu-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
