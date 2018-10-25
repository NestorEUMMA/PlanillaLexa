<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Permiso */

$this->title = $model->idEmpleado->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permiso-view">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdPermisos], ['class' => 'btn btn-z']) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idEmpleado.fullname',
            'DiasPermiso',
            'SalarioDescuento',
            'FechaPermiso',
            'PeriodoPermiso',
            'MesPermiso',
            'DescripcionPermiso',
        ],
    ]) ?>
</div>
