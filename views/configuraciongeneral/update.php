<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Configuraciongeneral */

$this->title = 'Actualizar Configuracion General';
$this->params['breadcrumbs'][] = ['label' => 'Configuraciones Generales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdConfiguracion, 'url' => ['view', 'id' => $model->IdConfiguracion]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="configuraciongeneral-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
