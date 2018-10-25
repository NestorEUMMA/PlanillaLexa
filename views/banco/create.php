<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Banco */

$this->title = 'Ingresar Banco';
$this->params['breadcrumbs'][] = ['label' => 'Bancos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



