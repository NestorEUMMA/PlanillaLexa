<?php


// Database Connection
 include '../../include/dbconnect.php';
 session_start();

 $queryconfiguraciongeneral = "SELECT SalarioMinimo from configuraciongeneral where IdConfiguracion = 1";
 $resultadoconfiguraciongeneral = $mysqli->query($queryconfiguraciongeneral);

 while ($test = $resultadoconfiguraciongeneral->fetch_assoc())
            {
                $salariominimo = $test['SalarioMinimo'];
            }


    $periodo = $_POST['Periodo'];





// get Users
$query = "SELECT CONCAT(RPAD(CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado), 40,' '),'',LPAD(REPLACE(e.Nit, '-', ''),14,' '),'',
LPAD(rpt.CodigoIngreso, 2, '0'),'',LPAD(SUM(REPLACE(rpt.MontoDevengado,'.','')), 15, ' '),'',LPAD(SUM(REPLACE(rpt.ImpuestoRetenido,'.','')), 15, '  '),'',
LPAD(SUM(REPLACE(rpt.AguinaldoExento,'.','')), 15, ' '),'',LPAD(SUM(REPLACE(rpt.AguinaldoGravado,'.','')), 15, ' '),'',LPAD(SUM(REPLACE(rpt.isss,'.','')), 15, ' '),'',
LPAD(SUM(REPLACE(rpt.afp,'.','')), 15, ' '),'',LPAD(SUM(REPLACE(rpt.ipsfa,'.','')), 15, ' '),'',LPAD(0, 15, ' '),'',LPAD(rpt.anio, 4, ' ')) AS 'F910'
FROM rptrentaanual rpt
INNER JOIN empleado e on rpt.IdEmpleado = e.IdEmpleado
where rpt.CodigoIngreso IN (select CodigoIngreso from codigoreporteanual) and rpt.Anio = '$periodo' and length(E.Nit) != 0
group by e.IdEmpleado";

if (!$result = mysqli_query($mysqli, $query)) {
    exit(mysqli_error($mysqli));
}

$users = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}

header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=F910 $periodo.txt");
$output = fopen('php://output', 'w');

$resultadointegracion = $mysqli->query($query);

while ($test = $resultadointegracion->fetch_assoc())
{
    fputs  ($output, $test["F910"]);
    fputs  ($output, "\r\n");

}
fclose ($output);

?>
