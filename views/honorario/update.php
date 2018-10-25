<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Honorario */

$this->title = 'Actualizar Honorario: ' . $model->idEmpleado->fullname	;
$this->params['breadcrumbs'][] = ['label' => 'Honorarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEmpleado->fullname, 'url' => ['view', 'id' => $model->IdHonorario]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="honorario-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
