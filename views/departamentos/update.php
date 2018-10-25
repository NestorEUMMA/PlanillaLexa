<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Departamentos */

$this->title = 'Actualizar Departamentos: ' . $model->NombreDepartamento;
$this->params['breadcrumbs'][] = ['label' => 'Departamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NombreDepartamento, 'url' => ['view', 'id' => $model->IdDepartamentos]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="departamentos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
