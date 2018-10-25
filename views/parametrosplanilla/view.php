<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Parametrosplanilla */

$this->title = $model->MesPlanilla;
$this->params['breadcrumbs'][] = ['label' => 'Parametrosplanillas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parametrosplanilla-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
      <?php $id = str_replace('id=',"", $_SERVER["QUERY_STRING"] ); ?>
      <button class="btn btn-success btn-raised btn-exp" value='<?php echo $id; ?>'>
               ELIMINAR <?php echo $id; ?>
      </button>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'IdParametroPlanilla',
            'FechaCreacion',
            'MesPlanilla',
            'PeriodoPlanilla',
            'QuincenaPlanilla',
        ],
    ]) ?>

</div>

<form id="frm" action="../../views/parametrosplanilla/delete.php" method="post" class="hidden">
  <input type="text" id="IdParametroPlanilla" name="IdParametroPlanilla" />
</form>

<script type="text/javascript">
    $(document).ready(function(){

        $(".btn-exp").click(function(){
            var id = $(this).attr("value");
            $("#IdParametroPlanilla").val(id);
            $("#frm").submit();
            //alert(id);
        });
    });

</script>
