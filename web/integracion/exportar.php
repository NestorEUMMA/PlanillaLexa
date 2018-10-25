<?php


// Database Connection
 include '../../include/dbconnect.php';
 session_start();

    $mes = $_POST['mes'];
    $periodo = $_POST['periodo'];
    $quincena = $_POST['quincena'];


// get Users
$query = "SELECT Date, Reference, DateBankRec, (select count(*) from integracionpeachtree where Mes = '$mes' and Periodo = '$periodo' and Quincena = '$quincena' and Amount <> 0.00) as 'NumberDistribution' ,Account, Description, ROUND(Amount,2) Amount, JobID, UsedReimbursable, TransactionPeriod, TransactionNumber, CosolidatedTransaction, RecurNumber, RecurFrequency
          FROM integracionpeachtree
          where Mes = '$mes' and Periodo = '$periodo' and Quincena = '$quincena' and Amount <> 0.00 and dependiente = 0";
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
header('Content-Disposition: attachment; filename=asiento.prn');
$output = fopen('php://output', 'w');
fputcsv($output, array('Date', 'Reference', 'Date Clear in Bank Rec', 'Number of Distributions', 'G/L Account', 'Description', 'Amount' ,'Job ID', 'Used for Reimbursable Expenses' ,'Transaction Period', 'Transaction Number', 'Consolidated Transaction', 'Recur Number', 'Recur Frequency'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
?>
