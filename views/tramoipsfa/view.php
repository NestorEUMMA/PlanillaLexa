<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tramoipsfa */

$this->title = $model->TramoIpsfa;
$this->params['breadcrumbs'][] = ['label' => 'Tramo IPSFA', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tramoipsfa-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdTramoIpsfa], ['class' => 'btn btn-z']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

             [
       'attribute' => 'TramoIpsfa',
       'value' => function ($model) {
           return '%' . ' ' . $model->TramoIpsfa;
       }
    ] ,
             [
       'attribute' => 'TechoIpsfa',
       'value' => function ($model) {
           return '$' . ' ' . $model->TechoIpsfa;
       }
    ] ,
     [
       'attribute' => 'TechoIpsfaSig',
       'value' => function ($model) {
           return '$' . ' ' . $model->TechoIpsfaSig;
       }
    ] ,
        ],
    ]) ?>

</div>
