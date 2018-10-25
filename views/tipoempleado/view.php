<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tipoempleado */

$this->title = $model->DescipcionTipoEmpleado;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Empleados', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipoempleado-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdTipoEmpleado], ['class' => 'btn btn-z']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdTipoEmpleado',
            'DescipcionTipoEmpleado',
        ],
    ]) ?>

</div>
