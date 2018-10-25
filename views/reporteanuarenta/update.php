<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rptrentaanual */

$this->title = 'Actualizar: ';
$this->params['breadcrumbs'][] = ['label' => 'Reporte Anual F910', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Idrptrentaanual, 'url' => ['view', 'id' => $model->Idrptrentaanual]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="rptrentaanual-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
