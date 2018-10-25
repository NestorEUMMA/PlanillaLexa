<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Menuusuario */

$this->title = $model->idMenuDetalle->DescripcionMenuDetalle;
$this->params['breadcrumbs'][] = ['label' => 'Menu Permiso', 'url' => ['index']];
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
            'IdMenuUsuario',
            'IdMenuDetalle',
            'MenuUsuarioActivo',
            'IdUsuario',
            'IdMenu',
            'TipoPermiso',
        ],
    ]) ?>

</div>
