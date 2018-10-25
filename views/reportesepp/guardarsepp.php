<html>
<head>
	<script src="../../web/plugins/jQuery/jQuery-2.2.0.min.js"></script>
</head>
<body>
 <?php

include '../../include/dbconnect.php';
session_start();

  $FechaIni = $_POST['FechaIni'];
  $FechaFin = $_POST['FechaFin'];
  $Periodo = $_POST['Periodo'];
  $Mes = $_POST['Mes'];
  $Dias = $_POST['Dias'];

      $queryreportesepp = "SELECT E.IdEmpleado as 'IDEMPLEADO',
      '1' AS 'PlanillaCodigosObservacion', (CONVERT((E.SalarioNominal), DECIMAL(10,2)) -
        CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
          THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
        END  -
        CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
          THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
        END)
        AS 'PlanillaIngresoBaseCotizacion',
        '8' AS 'PlanillaHorasJornadaLaboral',
        ('$Dias' - (CASE WHEN (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
      THEN 0 ELSE (SELECT SUM(P.DiasIncapacidad) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END )
      - (CASE WHEN (SELECT SUM(P.DiasPermiso) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
      THEN 0 ELSE (SELECT SUM(P.DiasPermiso) where FechaTransaccion between '$FechaIni' and '$FechaFin')
      END )) as 'PlanillaDiasCotizados',
      '0' AS 'PlanillaCotizacionVoluntariaAfiliado',
      '0' AS 'PlanillaCotizacionVoluntariaEmpleador', REPLACE(E.Nup, '_','') AS 'Nup',
      (CASE WHEN Ins.DescripcionInstitucion = 'AFP Confia' THEN 'COF'
         WHEN Ins.DescripcionInstitucion = 'AFP Crecer' THEN 'MAX'
      END) AS 'InstitucionPrevisional',
      E.PrimerNomEmpleado AS 'PrimerNombre',
      E.SegunNomEmpleado AS 'SegundoNombre',
      E.PrimerApellEmpleado AS 'PrimerApellido',
      E.SegunApellEmpleado AS 'SegundoApellido',
      E.ApellidoCasada AS 'ApellidoCasada',
      (CASE WHEN td.DescripcionTipoDocumento = 'Documento Unico de Identidad' THEN 'DUI'
      END) AS 'TipoDocumento', E.NumTipoDocumento AS 'NumeroDocumento'

      FROM Empleado E
      LEFT JOIN Planilla P on E.IdEmpleado = P.IdEmpleado
      INNER JOIN institucionprevisional Ins on E.IdInstitucionPre = Ins.IdInstitucionPre
      INNER JOIN tipodocumento td on E.IdTipoDocumento = td.IdTipoDocumento
          LEFT JOIN puestoempresa pu on  E.IdPuestoEmpresa = pu.IdPuestoEmpresa
          WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 0 and Ins.DescripcionInstitucion <> 'IPSFA' and td.DescripcionTipoDocumento = 'Documento Unico de Identidad'
          group by E.IdEmpleado";
      $resultadoqueryreportesepp = $mysqli->query($queryreportesepp);


      while ($row = $resultadoqueryreportesepp->fetch_assoc())
    {

          $IdEmpleado = $row['IDEMPLEADO'];
          $PlanillaCodigoObservacion = $row['PlanillaCodigosObservacion'];
          $PlanillaIngresoBaseCotizacion = $row['PlanillaIngresoBaseCotizacion'];
          $PlanillaHorasJornadaLaboral = $row['PlanillaHorasJornadaLaboral'];
          $PlanillaDiasCotizados = $row['PlanillaDiasCotizados'];
          $PlanillaCotizacionVoluntariaAfiliado = $row['PlanillaCotizacionVoluntariaAfiliado'];
          $PlanillaCotizacionVoluntariaEmpleador = $row['PlanillaCotizacionVoluntariaEmpleador'];
          $Nup = $row['Nup'];
          $InstitucionPrevisional = $row['InstitucionPrevisional'];
          $PrimerNombre = $row['PrimerNombre'];
          $SegundoNombre = $row['SegundoNombre'];
          $PrimerApellido = $row['PrimerApellido'];
          $SegundoApellido = $row['SegundoApellido'];
          $ApellidoCasada = $row['ApellidoCasada'];
          $TipoDocumento = $row['TipoDocumento'];
          $NumeroDocumento = $row['NumeroDocumento'];



            $insertsepp = "INSERT INTO rptsepp (
                                                IdEmpleado,
                                                CodigoSepp,
                                                PlanillaIngresoBaseCotizacion,
                                                PlanillaHorasJornadaLaboral,
                                                PlanillaDiasCotizados,
                                                PlanillaCotizacionVoluntariaAfiliado,
                                                PlanillaCotizacionVoluntariaEmpleador,
                                                Nup,
                                                InstitucionPrevisional,
                                                PrimerNombre,
                                                SegundoNombre,
                                                PrimerApellido,
                                                SegundoApellido,
                                                ApellidoCasada,
                                                TipoDocumento,
                                                NumeroDocumento,
                                                Periodo,
                                                Mes)"
                             . "VALUES ('$IdEmpleado','$PlanillaCodigoObservacion','$PlanillaIngresoBaseCotizacion','$PlanillaHorasJornadaLaboral','$PlanillaDiasCotizados','$PlanillaCotizacionVoluntariaAfiliado',
                                '$PlanillaCotizacionVoluntariaEmpleador','$Nup','$InstitucionPrevisional', '$PrimerNombre', '$SegundoNombre', '$PrimerApellido', '$SegundoApellido', '$ApellidoCasada',
                                '$TipoDocumento', '$NumeroDocumento', '$Periodo', '$Mes')";
                              $resultadoqueryinsertsep = $mysqli->query($insertsepp);



    }
     header('Location: ../../web/reportesepp/index');

?>
</body>
</html>
