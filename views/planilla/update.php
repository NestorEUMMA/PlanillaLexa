<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Planilla */

$this->title = 'Actualizar Planilla: ' . $model->IdPlanilla;
$this->params['breadcrumbs'][] = ['label' => 'Planillas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdPlanilla, 'url' => ['view', 'id' => $model->IdPlanilla]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="planilla-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
