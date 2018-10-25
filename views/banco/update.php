<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Banco */

$this->title = 'Actualizar Banco: ' . $model->DescripcionBanco;
$this->params['breadcrumbs'][] = ['label' => 'Bancos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DescripcionBanco, 'url' => ['view', 'id' => $model->IdBanco]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="banco-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
