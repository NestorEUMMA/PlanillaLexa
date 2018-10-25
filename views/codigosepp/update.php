<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Codigosepp */

$this->title = 'Actualizar Codigosepp: ' . $model->CodigoSepp;
$this->params['breadcrumbs'][] = ['label' => 'Codigosepps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CodigoSepp, 'url' => ['view', 'id' => $model->CodigoSepp]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="codigosepp-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
