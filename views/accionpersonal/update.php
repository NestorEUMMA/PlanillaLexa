<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Accionpersonal */

$this->title = 'Actualizar Accion Personal: ' . $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Accion Personal', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEmpleado->fullname,, 'url' => ['view', 'id' => $model->IdAccionPersonal]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="accionpersonal-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
