<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Municipios */

$this->title = 'Ingresar Municipios';
$this->params['breadcrumbs'][] = ['label' => 'Municipios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



