<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Horario */

$this->title = 'Actualizar Horario: ' . $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Horarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEmpleado->fullname, 'url' => ['view', 'id' => $model->IdHorario]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="horario-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
