<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Parametrosplanilla */

$this->title = 'Actualizar Parametrosplanilla: ' . $model->IdParametroPlanilla;
$this->params['breadcrumbs'][] = ['label' => 'Parametrosplanillas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdParametroPlanilla, 'url' => ['view', 'id' => $model->IdParametroPlanilla]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="parametrosplanilla-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
