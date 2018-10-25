<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bonos */

$this->title = 'Actualizar Bonos: ' . $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Bonos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEmpleado->fullname, 'url' => ['view', 'id' => $model->IdBono]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="bonos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
