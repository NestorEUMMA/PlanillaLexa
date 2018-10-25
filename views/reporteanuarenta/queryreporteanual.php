<?php

$queryreporteanual = "SELECT RPAD(CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado), 40," ") AS 'NOMBRECOMPLETO', LPAD(REPLACE(e.Nit, "-", ""),14," ") as 'NIT',
LPAD(rpt.CodigoIngreso, 2, "0") as 'CODIGO INGRESO', LPAD(SUM(REPLACE(rpt.MontoDevengado,".","")), 15, " ") AS 'MONTO DEVENGADO', LPAD(SUM(REPLACE(rpt.ImpuestoRetenido,".","")), 15, " ") AS 'IMPUESTO RETENIDO',
LPAD(SUM(REPLACE(rpt.AguinaldoExento,".","")), 15, " ") AS 'AGUINALDO EX', LPAD(SUM(REPLACE(rpt.AguinaldoGravado,".","")), 15, " ") AS 'AGUINALDO GRAV', LPAD(SUM(REPLACE(rpt.isss,".","")), 15, " ") AS 'ISSS',
LPAD(SUM(REPLACE(rpt.afp,".","")), 15, " ") AS 'AFP', LPAD(SUM(REPLACE(rpt.ipsfa,".","")), 15, " ") AS 'IPSFA', LPAD(0, 15, " ") AS 'BIENESTAR MAGISTRAL', LPAD(rpt.anio, 4, " ") AS 'AÑO'
FROM rptrentaanual rpt
INNER JOIN empleado e on rpt.IdEmpleado = e.IdEmpleado
where rpt.CodigoIngreso IN (select CodigoIngreso from codigoreporteanual) and rpt.Anio = 2018 and length(E.Nit) != 0
group by e.IdEmpleado

";

 ?>
