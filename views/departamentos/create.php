<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Departamentos */

$this->title = 'Ingresar Departamentos';
$this->params['breadcrumbs'][] = ['label' => 'Departamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


		<div>
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>



