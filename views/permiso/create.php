<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Permiso */

$this->title = 'Ingresar Permiso';
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



