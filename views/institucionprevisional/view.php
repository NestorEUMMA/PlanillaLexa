<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Institucionprevisional */

$this->title = $model->DescripcionInstitucion;
$this->params['breadcrumbs'][] = ['label' => 'Institucion Previsional', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institucionprevisional-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdInstitucionPre], ['class' => 'btn btn-z']) ?>
       
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdInstitucionPre',
            'DescripcionInstitucion',
        ],
    ]) ?>

</div>
