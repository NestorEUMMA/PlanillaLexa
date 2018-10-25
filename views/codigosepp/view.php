<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Codigosepp */

$this->title = $model->CodigoSepp;
$this->params['breadcrumbs'][] = ['label' => 'Codigosepps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="codigosepp-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->CodigoSepp], ['class' => 'btn btn-z']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->CodigoSepp], [
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
            'CodigoSepp',
            'Descripcion',
        ],
    ]) ?>

</div>
