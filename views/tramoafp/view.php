<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramoafp */

$this->title = $model->TramoAfp;
$this->params['breadcrumbs'][] = ['label' => 'Tramo AFP', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramoafp-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdTramoAfp], ['class' => 'btn btn-z']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdTramoAfp'

                         [
       'attribute' => 'TramoAfp',
       'value' => function ($model) {
           return '%' . ' ' . $model->TramoAfp;
       }
    ] ,
             [
       'attribute' => 'TechoAfp',
       'value' => function ($model) {
           return '$' . ' ' . $model->TechoAfp;
       }
    ] ,
     [
       'attribute' => 'TechoAfpSig',
       'value' => function ($model) {
           return '$' . ' ' . $model->TechoAfpSig;
       }
    ] ,
        ],
    ]) ?>

</div>
