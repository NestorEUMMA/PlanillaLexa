<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rptsepp */

$this->title = 'Actualizar SEPP: ' . $model->IdReporteSepp;
$this->params['breadcrumbs'][] = ['label' => 'SEPP', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdReporteSepp, 'url' => ['view', 'id' => $model->IdReporteSepp]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="rptsepp-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
