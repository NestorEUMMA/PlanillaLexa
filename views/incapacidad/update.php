<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Incapacidad */

$this->title = 'Actualizar Incapacidad: ' . $model->IdIncapacidad;
$this->params['breadcrumbs'][] = ['label' => 'Incapacidads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdIncapacidad, 'url' => ['view', 'id' => $model->IdIncapacidad]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="incapacidad-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
