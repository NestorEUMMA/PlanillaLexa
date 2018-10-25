<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tipodocumento */

$this->title = 'Actualizar Tipo Documento: ' . $model->DescripcionTipoDocumento;
$this->params['breadcrumbs'][] = ['label' => 'Tipodocumentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DescripcionTipoDocumento, 'url' => ['view', 'id' => $model->IdTipoDocumento]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipodocumento-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
