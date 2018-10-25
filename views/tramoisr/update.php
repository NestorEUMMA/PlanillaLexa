<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tramoisr */

$this->title = 'Actualizar Tramo ISR: ' . $model->NumTramo;
$this->params['breadcrumbs'][] = ['label' => 'Tramo ISR', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NumTramo, 'url' => ['view', 'id' => $model->IdTramoIsr]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tramoisr-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
