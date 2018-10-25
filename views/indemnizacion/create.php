<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Indemnizacion */

$this->title = 'Ingresar Indemnizacion';
$this->params['breadcrumbs'][] = ['label' => 'Indemnizacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



