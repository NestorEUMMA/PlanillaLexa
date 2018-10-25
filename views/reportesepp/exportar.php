<?php


// Database Connection
 include '../../include/dbconnect.php';
 session_start();

    $mes = $_POST['Mes'];
    $periodo = $_POST['Periodo'];


// get Users
$query = "SELECT CodigoSepp,PlanillaIngresoBaseCotizacion,PlanillaHorasJornadaLaboral,PlanillaDiasCotizados,PlanillaCotizacionVoluntariaAfiliado,PlanillaCotizacionVoluntariaEmpleador,
    Nup,InstitucionPrevisional,PrimerNombre,REPLACE(SegundoNombre,' ',''),PrimerApellido,REPLACE(SegundoApellido,' ',''),REPLACE(ApellidoCasada,' ',''),TipoDocumento,NumeroDocumento
FROM rptsepp
where  Mes = '$mes' and Periodo = '$periodo'";
if (!$result = mysqli_query($mysqli, $query)) {
    exit(mysqli_error($mysqli));
}

$users = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=planilla sepp.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array("CodigoSepp", "PlanillaIngresoBaseCotizacion", 'PlanillaHorasJornadaLaboral', 'PlanillaDiasCotizados', 'PlanillaCotizacionVoluntariaAfiliado',
'PlanillaCotizacionVoluntariaEmpleador', 'Nup' ,'InstitucionPrevisional', 'PrimerNombre' ,'SegundoNombre', 'PrimerApellido', 'SegundoApellido','ApellidoCasada',  'TipoDocumento','NumeroDocumento'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>
