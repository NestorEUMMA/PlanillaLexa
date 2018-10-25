<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Propinas */

$this->title = 'Ingresar Propinas';
$this->params['breadcrumbs'][] = ['label' => 'Propinas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



