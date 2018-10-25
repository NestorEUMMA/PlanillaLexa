<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rptrentaanual */

$this->title = 'Ingresar Rptrentaanual';
$this->params['breadcrumbs'][] = ['label' => 'Rptrentaanuals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



