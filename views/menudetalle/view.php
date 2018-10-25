<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Menudetalle */

$this->title = $model->DescripcionMenuDetalle;
$this->params['breadcrumbs'][] = ['label' => 'Menu Detalle', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menudetalle-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdMenuDetalle], ['class' => 'btn btn-z']) ?>
       
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdMenuDetalle',
            'idMenu.DescripcionMenu',
            'DescripcionMenuDetalle',
            'Url:url',
            'Icono',
        ],
    ]) ?>

</div>
