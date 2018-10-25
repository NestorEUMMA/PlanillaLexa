<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Parametros */

$this->title = 'Actualizar Parametros: ' . $model->ISRParametro;
$this->params['breadcrumbs'][] = ['label' => 'Parametros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ISRParametro, 'url' => ['view', 'id' => $model->IdParametro]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="parametros-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
