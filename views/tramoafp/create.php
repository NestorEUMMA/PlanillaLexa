<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tramoafp */

$this->title = 'Ingresar Tramo AFP';
$this->params['breadcrumbs'][] = ['label' => 'Tramo AFP', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



