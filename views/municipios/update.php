<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Municipios */

$this->title = 'Actualizar Municipios: ' . $model->DescripcionMunicipios;
$this->params['breadcrumbs'][] = ['label' => 'Municipios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DescripcionMunicipios, 'url' => ['view', 'id' => $model->IdMunicipios]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="municipios-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
