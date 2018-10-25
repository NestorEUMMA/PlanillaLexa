<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tramoisss */

$this->title = 'Ingresar Tramo ISSS';
$this->params['breadcrumbs'][] = ['label' => 'Tramo ISSS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



