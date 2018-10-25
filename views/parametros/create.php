<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Parametros */

$this->title = 'Ingresar Parametros';
$this->params['breadcrumbs'][] = ['label' => 'Parametros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



