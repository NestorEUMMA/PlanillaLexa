<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Catalogocuentas */

$this->title = 'Actualizar Catalogocuentas: ' . $model->Descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Catalogocuentas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Descripcion, 'url' => ['view', 'id' => $model->IdCatalogoCuentas]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="catalogocuentas-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
