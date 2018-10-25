<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Horasextras */

$this->title = 'Actualizar Horasextras: ' . $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Horasextras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEmpleado->fullname, 'url' => ['view', 'id' => $model->IdHorasExtras]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="horasextras-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
