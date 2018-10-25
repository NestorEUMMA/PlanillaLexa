<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Anticipos */

$this->title = 'Actualizar Anticipos: ' . $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Anticipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEmpleado->fullname, 'url' => ['view', 'id' => $model->IdAnticipo]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="anticipos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
