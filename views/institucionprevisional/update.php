<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Institucionprevisional */

$this->title = 'Actualizar Institucion Previsional: ' . $model->DescripcionInstitucion;
$this->params['breadcrumbs'][] = ['label' => 'Institucion Previsional', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DescripcionInstitucion, 'url' => ['view', 'id' => $model->IdInstitucionPre]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="institucionprevisional-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
