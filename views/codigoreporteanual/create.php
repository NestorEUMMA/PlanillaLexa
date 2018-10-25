<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Codigoreporteanual */

$this->title = 'Ingresar Codigo de Ingreso';
$this->params['breadcrumbs'][] = ['label' => 'Codigo de Ingreso', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
