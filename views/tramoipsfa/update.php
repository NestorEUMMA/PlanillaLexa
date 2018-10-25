<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tramoipsfa */

$this->title = 'Actualizar Tramo IPSFA: ' . $model->TramoIpsfa;
$this->params['breadcrumbs'][] = ['label' => 'Tramo IPSFA', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TramoIpsfa, 'url' => ['view', 'id' => $model->IdTramoIpsfa]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tramoipsfa-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
