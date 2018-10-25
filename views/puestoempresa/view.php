<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Puestoempresa */

$this->title = $model->DescripcionPuestoEmpresa;
$this->params['breadcrumbs'][] = ['label' => 'Puesto Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="puestoempresa-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdPuestoEmpresa], ['class' => 'btn btn-z']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdPuestoEmpresa',
            'idDepartamentoEmpresa.DescripcionDepartamentoEmpresa',
            'DescripcionPuestoEmpresa',
        ],
    ]) ?>

</div>
