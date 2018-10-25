<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Puestoempresa */

$this->title = 'Actualizar Puestoempresa: ' . $model->DescripcionPuestoEmpresa;
$this->params['breadcrumbs'][] = ['label' => 'Puesto Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DescripcionPuestoEmpresa, 'url' => ['view', 'id' => $model->IdPuestoEmpresa]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="puestoempresa-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
