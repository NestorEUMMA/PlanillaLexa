<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Departamentoempresa */

$this->title = 'Actualizar Departamento Empresa: ' . $model->DescripcionDepartamentoEmpresa;
$this->params['breadcrumbs'][] = ['label' => 'Departamento Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DescripcionDepartamentoEmpresa, 'url' => ['view', 'id' => $model->IdDepartamentoEmpresa]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="departamentoempresa-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
