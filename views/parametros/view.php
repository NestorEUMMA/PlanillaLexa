<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Parametros */

$this->title = $model->ISRParametro;
$this->params['breadcrumbs'][] = ['label' => 'Parametros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parametros-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdParametro], ['class' => 'btn btn-z']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'IdParametro',
            'ISRParametro',
        ],
    ]) ?>

</div>
