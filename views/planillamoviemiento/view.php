<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Planilla */

$this->title = $model->IdPlanilla;
$this->params['breadcrumbs'][] = ['label' => 'Planillas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planilla-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdPlanilla], ['class' => 'btn btn-z']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->IdPlanilla], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Usted esta seguro de Eliminar este campo?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'IdPlanilla',
            'IdEmpleado',
            'Honorario',
            'Comision',
            'Bono',
            'Anticipos',
            'HorasExtras',
            'Vacaciones',
            'MesPlanilla',
            'AnioPlanilla',
            'FechaTransaccion',
            'ISRPlanilla',
            'AFPPlanilla',
            'ISSSPlanilla',
        ],
    ]) ?>

</div>
