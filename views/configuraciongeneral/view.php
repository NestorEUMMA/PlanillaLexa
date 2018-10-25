<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Configuraciongeneral */

$this->title = 'Configuracion';
$this->params['breadcrumbs'][] = ['label' => 'Configuraciones Generales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configuraciongeneral-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdConfiguracion], ['class' => 'btn btn-z']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdConfiguracion',
            'SalarioMinimo',
            'ComisionesConfig:boolean',
            'HorasExtrasConfig:boolean',
            'BonosConfig:boolean',
            'HonorariosConfig:boolean',
        ],
    ]) ?>

</div>
