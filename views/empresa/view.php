<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */

$this->title = $model->NombreEmpresa;
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <!-- <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->NombreEmpresa], ['class' => 'btn btn-z']) ?>

    </p> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//IdEmpresa',
            'NombreEmpresa',
            'Direccion',
            'idDepartamentos.NombreDepartamento',
            'idMunicipios.DescripcionMunicipios',
            'GiroFiscal',
            'NrcEmpresa',
            'NitEmpresa',
            'NuPatronal',
            'Representante',
            [
               'attribute'=>'ImagenEmpresa',
               'value'=> Yii::$app->homeUrl.'/'.$model->ImagenEmpresa,
               'format' => ['image',['width'=>'100','height'=>'100']],
            ],
        ],
    ]) ?>

</div>
