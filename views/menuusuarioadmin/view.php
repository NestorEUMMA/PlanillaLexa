<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Menuusuario */

$this->title = $model->idMenu->DescripcionMenu;
$this->params['breadcrumbs'][] = ['label' => 'Menu Usuario', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menuusuario-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->IdMenuUsuario], ['class' => 'btn btn-z']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idUsuario.InicioSesion',
            'idMenu.DescripcionMenu',
            'idMenuDetalle.DescripcionMenuDetalle',

                        [
                'format' => 'boolean',
                'attribute' => 'MenuUsuarioActivo',
                'filter' => [0=>'No',1=>'Si'],
                ],
            //'TipoPermiso',
        ],
    ]) ?>

</div>
