<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Menudetalle */
$this->title = 'Ingresar Menu Detalle';
$this->params['breadcrumbs'][] = ['label' => 'Menu Detalle', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



