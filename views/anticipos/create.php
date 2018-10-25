<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Anticipos */

$this->title = 'Ingresar Anticipos';
$this->params['breadcrumbs'][] = ['label' => 'Anticipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



