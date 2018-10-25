<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Estadocivil */

$this->title = $model->DescripcionEstadoCivil;
$this->params['breadcrumbs'][] = ['label' => 'Estado Civil', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estadocivil-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->DescripcionEstadoCivil], ['class' => 'btn btn-z']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdEstadoCivil',
            'DescripcionEstadoCivil',
        ],
    ]) ?>

</div>
