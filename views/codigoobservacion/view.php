<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Codigoobservacion */

$this->title = $model->DescripcionCodigo;
$this->params['breadcrumbs'][] = ['label' => 'Codigo Observacion', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="codigoobservacion-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdCodigoObservacion], ['class' => 'btn btn-z']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdCodigoObservacion',
            'Codigo',
            'DescripcionCodigo',
        ],
    ]) ?>

</div>
