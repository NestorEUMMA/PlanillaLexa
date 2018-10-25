       <?php
    include '../../include/dbconnect.php';
    session_start();

    if (!empty($_SESSION['user']))
      { 
          $urluri = str_replace('?'.$_SERVER["QUERY_STRING"],"", $_SERVER["REQUEST_URI"] );

      //   $validarmenu = "select me.url as 'url' from menudetalle me
      //             inner join menuusuario mu on me.IdMenuDetalle = mu.IdMenuDetalle
      //             inner join usuario u on mu.IdUsuario = u.IdUsuario
      //             where u.InicioSesion = '" . $_SESSION['user'] . "'  and me.Url = '" . str_replace('/SisPlanillasLexa/web/','../', $_SERVER["REQUEST_URI"]) . "'";
      //   $resultadovalidarmenu = $mysqli->query($validarmenu);

      // if (mysqli_num_rows($resultadovalidarmenu) <> 0)
      //     {
      //        header( "Location: ../site/index" );

    
     $queryempleado = "SELECT IdEmpleado, concat(PrimerNomEmpleado,' ',SegunNomEmpleado,' ',PrimerApellEmpleado,' ',SegunApellEmpleado) AS 'NOMBRECOMPLETO', SalarioNominal AS 'SALARIO', EmpleadoActivo As 'ACTIVO' FROM empleado ORDER BY PrimerNomEmpleado ASC";
        $resultadoempleado = $mysqli->query($queryempleado);

        $id =$_REQUEST['IdEmpleado'];
                  
                  $queryexpedientes = "SELECT 
    E.IdEmpleado, 
    E.Nup, 
    TD.DescripcionTipoDocumento AS 'IdTipoDocumento', 
    E.NumTipoDocumento, 
    IP.DescripcionInstitucion AS 'IdInstitucionPre', 
    E.Genero, 
    E.PrimerNomEmpleado, 
    E.SegunNomEmpleado, 
    E.PrimerApellEmpleado, 
    E.SegunApellEmpleado, 
    E.ApellidoCasada, 
    E.ConocidoPor, 
    TE.DescipcionTipoEmpleado AS 'IdTipoEmpleado', 
    EC.DescripcionEstadoCivil AS 'IdEstadoCivil', 
    E.FNacimiento, 
    E.NIsss, 
    E.MIpsfa, 
    E.Nit, 
    E.SalarioNominal,
    PE.DescripcionPuestoEmpresa AS 'IdPuestoEmpresa', 
    E.Direccion, 
    D.NombreDepartamento AS 'IdDepartamentos',
    M.DescripcionMunicipios AS 'IdMunicipios', 
    E.CorreoElectronico, 
    E.TelefonoEmpleado, 
    E.CelularEmpleado, 
    E.CBancaria, 
    B.DescripcionBanco AS 'IdBanco', 
    E.CasoEmergencia, 
    E.TeleCasoEmergencia, 
    E.Dependiente1, 
    E.Dependiente2, 
    E.Dependiente3, 
    E.Beneficiario, 
    E.DocumentBeneficiario,
    E.NDocBeneficiario, 
    E.DeducIsssAfp, 
    E.DeducIsssIpsfa, 
    E.NoDependiente, 
    E.EmpleadoActivo, 
    E.FechaContratacion, 
    E.FechaDespido
FROM empleado E
INNER JOIN tipodocumento TD on E.IdTipoDocumento = TD.IdTipoDocumento
INNER JOIN institucionprevisional IP on E.IdInstitucionPre = IP.IdInstitucionPre
INNER JOIN tipoempleado TE on E.IdTipoEmpleado = TE.IdTipoEmpleado
INNER JOIN estadocivil EC on E.IdEstadoCivil = EC.IdEstadoCivil
INNER JOIN puestoempresa PE on E.IdPuestoEmpresa = PE.IdPuestoEmpresa
INNER JOIN departamentos D on E.IdDepartamentos = D.IdDepartamentos
INNER JOIN municipios M on E.IdMunicipios = M.IdMunicipios
LEFT JOIN banco B on E.IdBanco = B.IdBanco
WHERE IdEmpleado = '$id'";
  $resultadoexpedientes = $mysqli->query($queryexpedientes);
  while ($test = $resultadoexpedientes->fetch_assoc())
  {
      $IdEmpleado = $test['IdEmpleado'];
      $Nup = $test['Nup'];
      $IdTipoDocumento = $test['IdTipoDocumento'];
      $IdTipoEmpleado = $test['IdTipoEmpleado'];
      $NumTipoDocumento = $test['NumTipoDocumento'];
      $IdInstitucionPre = $test['IdInstitucionPre'];
      $Genero = $test['Genero'];
      $PrimerNomEmpleado = $test['PrimerNomEmpleado'];
      $SegunNomEmpleado = $test['SegunNomEmpleado'];
      $PrimerApellEmpleado = $test['PrimerApellEmpleado'];
      $SegunApellEmpleado = $test['SegunApellEmpleado'];
      $ApellidoCasada = $test['ApellidoCasada'];
      $ConocidoPor = $test['ConocidoPor'];
      $IdTipoEmpleado = $test['IdTipoEmpleado'];
      $IdEstadoCivil = $test['IdEstadoCivil'];
      $FNacimiento = $test['FNacimiento'];
      $NIsss = $test['NIsss'];
      $MIpsfa = $test['MIpsfa'];
      $Nit = $test['Nit'];
      $SalarioNominal = $test['SalarioNominal'];
      $IdPuestoEmpresa = $test['IdPuestoEmpresa'];
      $Direccion = $test['Direccion'];
      $IdDepartamentos = $test['IdDepartamentos'];
      $IdMunicipios = $test['IdMunicipios'];
      $CorreoElectronico = $test['CorreoElectronico'];
      $TelefonoEmpleado = $test['TelefonoEmpleado'];
      $CelularEmpleado = $test['CelularEmpleado'];
      $CBancaria = $test['CBancaria'];
      $IdBanco = $test['IdBanco'];
      $CasoEmergencia = $test['CasoEmergencia'];
      $TeleCasoEmergencia = $test['TeleCasoEmergencia'];
      $Dependiente1 = $test['Dependiente1'];
      $Dependiente2 = $test['Dependiente2'];
      $Dependiente3 = $test['Dependiente3'];
      $Beneficiario = $test['Beneficiario'];
      $DocumentBeneficiario = $test['DocumentBeneficiario'];
      $NDocBeneficiario = $test['NDocBeneficiario'];
      $DeducIsssAfp = $test['DeducIsssAfp'];
      $NoDependiente = $test['NoDependiente'];
      $EmpleadoActivo = $test['EmpleadoActivo'];
      $FechaContratacion = $test['FechaContratacion'];
      $FechaDespido = $test['FechaDespido'];
  }

    $querydeduccionestabla = "SELECT IdDeduccionEmpleado, IdEmpleado, CONCAT('$',' ',SueldoEmpleado) AS 'SUELDOEMPLEADO', CONCAT('$',' ',DeducAfp) AS 'AFP', CONCAT('$',' ',DeducIsss) AS 'ISSS', CONCAT('$',' ',DeducIpsfa) AS 'IPSFA', 
CONCAT('$',' ',DeducIsr) AS 'ISR', CONCAT('$',' ',DeducIsssCot) AS 'ISSSCOT', CONCAT('$',' ',SueldoNeto) AS 'SUELDONETO', FechaCalculo AS 'FECHA' 
                    FROM deduccionempleado
                    WHERE IdEmpleado = '$id'
                    ORDER BY FechaCalculo DESC";
    $resultadodeduccionestabla = $mysqli->query($querydeduccionestabla);


    ?>

  <!doctype html>
<html lang="en">

<head>
        <title>Expediente</title>

       <?php include '../../include/include.php'; ?>

</head>

<body>
    <div class="wrapper">
        

      <?php include '../../include/aside2.php'; ?>


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
                        <a class="navbar-brand" href="#"> Inicio <?php echo  $url; ?> </a>
                    </div>
                    <div class="collapse navbar-collapse">
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                          <div class="col-lg-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li><a href="#"></i> Inicio</a></li>
                                <li><a href="index.php">Seleccionar Empleado</a></li>
                            </ul>
                            <!--breadcrumbs end -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">mail_outline</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Expediente de <?php echo $PrimerNomEmpleado.' '.$PrimerApellEmpleado;?></h4>

                                </div>
                            </div>
                            </div>
                      </div>
                    </div>
                </div>
            </div>
          <?php include '../../include/footer.php'; ?>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
        $(document).ready(function(){

            $(".btn-expe").click(function(){
                var id = $(this).attr("id").replace("btn","");
                $("#IdEmpleado").val(id);
                $("#frm").submit();
            });
        });

    </script>
    <?php
      //}
      // else
      // {
      //         echo "
      // <script>
      //   alert('Usted no tiene permiso para ingresar a esta pagina');
      //   document.location='../index.php';

      // </script>
      // ";

      // }
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

