<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tramoisss */

$this->title = 'Actualizar Tramo ISSS: ' . $model->TramoIsss;
$this->params['breadcrumbs'][] = ['label' => 'Tramo ISSS', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TramoIsss, 'url' => ['view', 'id' => $model->IdTramoIsss]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tramoisss-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
