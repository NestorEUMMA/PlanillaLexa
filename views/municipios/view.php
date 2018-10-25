<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Municipios */

$this->title = $model->DescripcionMunicipios;
$this->params['breadcrumbs'][] = ['label' => 'Municipios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="municipios-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdMunicipios], ['class' => 'btn btn-z']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdMunicipios',
            'DescripcionMunicipios',
            'IdPadre',
            'Nivel',
            'Jerarquia',
            'departamentos.NombreDepartamento',
        ],
    ]) ?>

</div>
