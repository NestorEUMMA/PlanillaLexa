<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Codigoobservacion */

$this->title = 'Actualizar Codigo Observacion: ' . $model->IdCodigoObservacion;
$this->params['breadcrumbs'][] = ['label' => 'Codigo Observacion', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdCodigoObservacion, 'url' => ['view', 'id' => $model->IdCodigoObservacion]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="codigoobservacion-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
