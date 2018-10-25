<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bonos */

$this->title = 'Ingresar Bonos';
$this->params['breadcrumbs'][] = ['label' => 'Bonos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



