<?php
include '../include/dbconnect.php';
if(!isset($_SESSION))
    {
        session_start();
    }



/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use app\assets\DashboardAsset;

if (!empty($_SESSION['user']))
  {

     // $urluri = str_replace('?'.$_SERVER["QUERY_STRING"],"", $_SERVER["REQUEST_URI"] );
     // $url = str_replace("/SisPlanillasLexa/web/","../",  $urluri );



     //    $validarmenu = "select me.url as 'url', mu.MenuUsuarioActivo from menudetalle me
     //              inner join menuusuario mu on me.IdMenuDetalle = mu.IdMenuDetalle
     //              inner join usuario u on mu.IdUsuario = u.IdUsuario
     //              where mu.MenuUsuarioActivo = 1 and u.InicioSesion = '" . $_SESSION['user'] . "'  and me.Url = '" . $url . "'";
     //    $resultadovalidarmenu = $mysqli->query($validarmenu);


      // if (mysqli_num_rows($resultadovalidarmenu) <> 0)
      //     {
      //        header( "Location: ../site/index" );





DashboardAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="icon" type="image/png" href="../../web/assets/img/lexa.png" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper">

      <?php include '../include/aside.php'; ?>
       <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> Inicio </a>
                    </div>
                    <div class="collapse navbar-collapse">
                    </div>
                </div>

            </nav>
            <div class="content">
                <div class="container-fluid">
              <?php echo Breadcrumbs::widget([
                'homeLink'=> ['url'=>'../site/index','label'=>'Inicio'],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>

                 </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="http://www.lexasal.com"> LEXA </a>, Soluciones para tu Empresa (VERSION 1.8)
                </div>
            </footer>
            </div>
        </div>




<?php $this->endBody() ?>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function() {


        demo.initDashboardPageCharts();

        demo.initVectorMap();

        demo.initMaterialWizard();
        setTimeout(function() {
            $('.card.wizard-card').addClass('active');
        }, 600);
    });
</script>
<?php $this->endPage() ?>

    <?php
    //    }
    //   else
    //   {
    //           echo "
    //   <script>
    //     alert('Usted no tiene permiso para ingresar a esta pagina');
    //     document.location='../site/index';

    //   </script>
    //   ";

    //   }
    }

    else{
      echo "
      <script>
        alert('No ha iniciado sesion');
        document.location='../index.php';

      </script>
      ";
    }
    ?>
