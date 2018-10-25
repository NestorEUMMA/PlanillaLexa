<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Parametrosplanilla */

$this->title = 'Ingresar Parametrosplanilla';
$this->params['breadcrumbs'][] = ['label' => 'Parametrosplanillas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



