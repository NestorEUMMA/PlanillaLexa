<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Estadocivil */

$this->title = 'Actualizar Estadocivil: ' . $model->IdEstadoCivil;
$this->params['breadcrumbs'][] = ['label' => 'Estadocivils', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdEstadoCivil, 'url' => ['view', 'id' => $model->IdEstadoCivil]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="estadocivil-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
