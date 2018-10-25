<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Propinas */

$this->title = 'Actualizar Propinas: ' . $model->IdPropina;
$this->params['breadcrumbs'][] = ['label' => 'Propinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdPropina, 'url' => ['view', 'id' => $model->IdPropina]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="propinas-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
