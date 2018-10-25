<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */

$this->title = 'Actualizar Empresa: ' . $model->IdEmpresa;
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdEmpresa, 'url' => ['view', 'id' => $model->IdEmpresa]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="empresa-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
