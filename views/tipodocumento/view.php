<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tipodocumento */

$this->title = $model->DescripcionTipoDocumento;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Documentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipodocumento-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdTipoDocumento], ['class' => 'btn btn-z']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdTipoDocumento',
            'DescripcionTipoDocumento',
        ],
    ]) ?>

</div>
