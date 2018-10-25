<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tramoipsfa */

$this->title = 'Ingresar Tramo  IPSFA';
$this->params['breadcrumbs'][] = ['label' => 'Tramo IPSFA', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



