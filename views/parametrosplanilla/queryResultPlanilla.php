<?php
$queryplanilla =  "SELECT ba.DescripcionBanco as 'BANCO', e.CBancaria as 'CUENTA', e.nit as 'NIT', pu.DescripcionPuestoEmpresa as 'PUESTOEMPRESA', E.IdEmpleado as 'IDEMPLEADO', CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado) AS 'NOMBRECOMPLETO',
/**************************** CALCULO SALARIO **************************/
(CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)
AS 'SALARIO',


15  as 'DIAS',
/************************** CALCULO COMISIONES + BONOS SEGUN FECHA *******************************/
0.00 as 'EXTRA',


/************************* CALCULO SUMA DE SALARIO + COMISIONES + BONOS SEGUN FECHA *******************************/
(CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)
AS 'TOTALSALARIO',



/************************ CALCULO ISSS **********************************/
(CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
*
(SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
>= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
END
WHEN E.DeducIsssIpsfa = 1  THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))

<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)

THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))

* (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)))) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1)
THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
END

WHEN E.Pensionado = 1  THEN
CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)))) * 0.00), DECIMAL(10,2))


WHEN E.NoDependiente = 1 THEN 
CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)))) * 0.00), DECIMAL(10,2))
END) AS 'ISSS',



/*********************** CALCULO AFP ************************************/
(CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
END


WHEN E.Pensionado = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
END


WHEN E.DeducIsssAfp = 0 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)))) * 0.00), DECIMAL(10,2))
END) AS 'AFP',

/********************************** CALCULO IPSFA  *****************************/
CASE
WHEN E.DeducIsssIpsfa = 1 THEN
CASE
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2))) >= (SELECT TechoIpsfaSig FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1)), DECIMAL(10,2))
END
WHEN E.DeducIsssAfp = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))
WHEN E.NoDependiente = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))
END AS 'IPSFA',






/****************************** CALCULO RENTA ISR **************************/
(CASE
WHEN ( CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)

* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END


/* ISR PARA PENSIONADOS*/
WHEN E.Pensionado = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END

/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.DeducIsssIpsfa = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.10), DECIMAL(10,2))
END) IS NULL THEN 0.00 ELSE
( CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.DeducIsssIpsfa = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END


/* ISR PARA PENSIONADOS*/
WHEN E.Pensionado = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.10), DECIMAL(10,2))
END) + (CASE WHEN (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0.00 ELSE (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)
END) +
CONVERT((CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2))  where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END) ELSE 0.00 END)
+
(CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END) ELSE 0.00 END)
+

(CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END)ELSE 0.00 END),DECIMAL(10,2)) AS 'RENTA',





/********************************** CALCULO SUMA ISSS + AFP + RENTA GLOBAL ********************************/
(CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
*
(SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
>= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
END


WHEN E.Pensionado = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
END


WHEN E.DeducIsssIpsfa = 1  THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))

<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)

THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))

* (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)))) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1)
THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
END

WHEN E.NoDependiente = 1 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)+(CASE WHEN SUM(P.Comision) IS NULL THEN 0 ELSE SUM(P.Comision) END + CASE WHEN SUM(P.Bono) IS NULL THEN 0 ELSE SUM(P.Bono) END)) * 0.00), DECIMAL(10,2))
END)

+

(CASE
WHEN E.DeducIsssIpsfa = 1 THEN
CASE
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2))) >= (SELECT TechoIpsfaSig FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1)), DECIMAL(10,2))
END
WHEN E.DeducIsssAfp = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))
WHEN E.NoDependiente = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))
END)

+
(CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))))
>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
END


WHEN E.Pensionado = 1  THEN
CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)+(CASE WHEN SUM(P.Comision) IS NULL THEN 0 ELSE SUM(P.Comision) END + CASE WHEN SUM(P.Bono) IS NULL THEN 0 ELSE SUM(P.Bono) END)) * 0.00), DECIMAL(10,2))


WHEN E.DeducIsssAfp = 0 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)))) * 0.00), DECIMAL(10,2))
END)
+
(CASE
WHEN ( CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END


/* PENSIONADOS 1 */

WHEN E.Pensionado = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END


/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.DeducIsssIpsfa = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.10), DECIMAL(10,2))
END) IS NULL THEN 0 ELSE
( CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.DeducIsssIpsfa = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END

/* PENSIONADOS 1 */

WHEN E.Pensionado = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) 
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2))) * 0.10), DECIMAL(10,2)) END) 
+ 
(CASE WHEN (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0.00 ELSE (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)
END) +
CONVERT((CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2))  where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END) ELSE 0.00 END)
+
(CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END) ELSE 0.00 END)
+

(CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END)ELSE 0.00 END),DECIMAL(10,2))
AS 'TOTALPERCEPCION',

/********************************** CALCULO ANTICIPOS ********************************/

0.00 as 'ANTICIPOS',

/********************************** CALCULO SALARIO LIQUIDO ********************************/

(CASE WHEN

(CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END
+
CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') END
+
CASE WHEN
(SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END) IS NULL
THEN 0 ELSE
(CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END
+
CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') END
+
CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)

+ (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)END)

-
(CASE WHEN (SELECT SUM(Anticipos)  where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL THEN 0.00 ELSE (SELECT SUM(Anticipos)  where FechaTransaccion between '$FechaIni' and '$FechaFin')  END)

-

((CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END))
<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END))
*
(SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END))
>= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
END

WHEN E.Pensionado = 1  THEN
CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)+(CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END + CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)) * 0.00), DECIMAL(10,2))


WHEN E.DeducIsssIpsfa = 1  THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END))

<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)

THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END))

* (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END)) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1)
THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
END

WHEN E.NoDependiente = 1 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)+(CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') END +
CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)) * 0.00), DECIMAL(10,2))
END)

+

(CASE
WHEN E.DeducIsssIpsfa = 1 THEN
CASE
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) <= (SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1)), DECIMAL(10,2))
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) >= (SELECT TechoIpsfaSig FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1)), DECIMAL(10,2))
END
WHEN E.DeducIsssAfp = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.00), DECIMAL(10,2))
WHEN E.NoDependiente = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.00), DECIMAL(10,2))
END)

+
(CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END))
<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END))
* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END))
>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
END

WHEN E.Pensionado = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END))
<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END))
* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END))
>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
END

WHEN E.DeducIsssAfp = 0 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) where FechaTransaccion between '$FechaIni' and '$FechaFin')
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) where FechaTransaccion between '$FechaIni' and '$FechaFin')
  END)ELSE 0.00 END)) * 0.00), DECIMAL(10,2))
END)

+

(CASE
WHEN ( CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.DeducIsssIpsfa = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* PENSIONADOS 1 */

WHEN E.Pensionado = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.10), DECIMAL(10,2))
END) IS NULL THEN 0 ELSE
( CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.DeducIsssIpsfa = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END

/* PENSIONADOS 1 */

WHEN E.Pensionado = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END


/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END  -

CASE WHEN (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END
) * 0.10), DECIMAL(10,2))
END) + (CASE WHEN (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL THEN 0 ELSE (SELECT SUM(P.ISRPlanilla) where FechaTransaccion between '$FechaIni' and '$FechaFin') END)
END)

) +
CONVERT((CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2))  where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END) ELSE 0.00 END)
+
(CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END) ELSE 0.00 END)
+

(CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin') IS NULL
THEN 0 ELSE (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) where FechaTransaccion between '$FechaIni' and '$FechaFin')
END)ELSE 0.00 END),DECIMAL(10,2))
AS 'SALARIOLIQUIDO'

FROM Empleado E
LEFT JOIN Planilla P on E.IdEmpleado = P.IdEmpleado
LEFT JOIN puestoempresa pu on  E.IdPuestoEmpresa = pu.IdPuestoEmpresa
LEFT JOIN banco ba on e.IdBanco = ba.IdBanco
WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 0 
and E.IdEmpleado NOT IN ( SELECT IdEmpleado FROM PLANILLA WHERE FechaTransaccion between '$FechaIni' AND '$FechaFin' group by IdEmpleado)
group by E.IdEmpleado

UNION ALL

SELECT ba.DescripcionBanco as 'BANCO', e.CBancaria as 'CUENTA', e.nit as 'NIT', pu.DescripcionPuestoEmpresa as 'PUESTOEMPRESA', E.IdEmpleado as 'IDEMPLEADO',  CONCAT(E.PrimerNomEmpleado,' ',E.SegunNomEmpleado,' ',E.PrimerApellEmpleado,' ',E.SegunApellEmpleado) AS 'NOMBRECOMPLETO',

/**************************** CALCULO SALARIO **************************/
(CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
AS 'SALARIO',



15 - (CASE WHEN (SELECT SUM(P.DiasIncapacidad) )  IS NULL
THEN 0 ELSE (SELECT SUM(P.DiasIncapacidad) )
END )
- (CASE WHEN (SELECT SUM(P.DiasPermiso) )  IS NULL
THEN 0 ELSE (SELECT SUM(P.DiasPermiso) )
END ) as 'DIAS',



/************************** CALCULO COMISIONES + BONOS SEGUN FECHA *******************************/
CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.HorasExtras) ) END + CASE WHEN ( SELECT SUM(P.Comision) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Comision) ) END + CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Bono) ) END as 'EXTRA',



/************************* CALCULO SUMA DE SALARIO + COMISIONES + BONOS SEGUN FECHA *******************************/
CASE
WHEN
(CASE
WHEN (SELECT SUM(P.Comision) )  IS NULL
THEN 0 ELSE (SELECT SUM(P.Comision) )
END
+
CASE
WHEN (SELECT SUM(P.Bono) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Bono) )
END
+
CASE
WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
END
)
IS NULL THEN 0 ELSE
(CASE WHEN
(SELECT SUM(P.Comision) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) ) END
+
CASE WHEN (SELECT SUM(P.Bono) ) IS NULL THEN 0 ELSE (SELECT  SUM(P.Bono) )
END
+
CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL THEN 0 ELSE (SELECT  SUM(P.HorasExtras) )
END
)
+ (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
END AS 'TOTALSALARIO',




/************************ CALCULO ISSS **********************************/
(CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
*
(SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
>= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
END
WHEN E.DeducIsssIpsfa = 1  THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))

<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)

THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))

* (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END)) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1)
THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
END

WHEN E.Pensionado = 1  THEN
CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+(CASE WHEN (SELECT SUM(P.Comision) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) ) END
+ CASE WHEN (SELECT SUM(P.Bono) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) ) END)) * 0.00), DECIMAL(10,2))



WHEN E.NoDependiente = 1 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+(CASE WHEN (SELECT SUM(P.Comision) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) ) END +
CASE WHEN (SELECT SUM(P.Bono) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) ) END)) * 0.00), DECIMAL(10,2))
END) AS 'ISSS',



/*********************** CALCULO AFP ************************************/
(CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
END


WHEN E.Pensionado = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
END


WHEN E.DeducIsssAfp = 0 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END)) * 0.00), DECIMAL(10,2))
END) AS 'AFP',

/********************************** CALCULO IPSFA  *****************************/
CASE
WHEN E.DeducIsssIpsfa = 1 THEN
CASE
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1)), DECIMAL(10,2))
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoIpsfaSig FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1)), DECIMAL(10,2))
END
WHEN E.DeducIsssAfp = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))
WHEN E.NoDependiente = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))
END AS 'IPSFA',






/****************************** CALCULO RENTA ISR **************************/
(CASE
WHEN ( CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)

* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END


/* ISR PARA PENSIONADOS*/
WHEN E.Pensionado = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END

/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.DeducIsssIpsfa = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.10), DECIMAL(10,2))
END) IS NULL THEN 0.00 ELSE
( CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.DeducIsssIpsfa = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END


/* ISR PARA PENSIONADOS*/
WHEN E.Pensionado = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.10), DECIMAL(10,2))
END) + (CASE WHEN (SELECT SUM(P.ISRPlanilla) ) IS NULL THEN 0.00 ELSE (SELECT SUM(P.ISRPlanilla) ) END)
END) +
CONVERT((CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2))  ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) )
END) ELSE 0.00 END)
+
(CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) )
END) ELSE 0.00 END)
+

(CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) )
END)ELSE 0.00 END),DECIMAL(10,2)) AS 'RENTA',





/********************************** CALCULO SUMA ISSS + AFP + RENTA GLOBAL ********************************/
(CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
*
(SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
>= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
END


WHEN E.Pensionado = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
END


WHEN E.DeducIsssIpsfa = 1  THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))

<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)

THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))

* (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END)) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1)
THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
END

WHEN E.NoDependiente = 1 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+(CASE WHEN (SELECT SUM(P.Comision) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) ) END + CASE WHEN (SELECT SUM(P.Bono) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) ) END)) * 0.00), DECIMAL(10,2))
END)

+

(CASE
WHEN E.DeducIsssIpsfa = 1 THEN
CASE
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1)), DECIMAL(10,2))
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoIpsfaSig FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1)), DECIMAL(10,2))
END
WHEN E.DeducIsssAfp = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))
WHEN E.NoDependiente = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))
END)

+
(CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
END


WHEN E.Pensionado = 1  THEN
CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+(CASE WHEN (SELECT SUM(P.Comision) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) ) END + CASE WHEN (SELECT SUM(P.Bono) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) ) END)) * 0.00), DECIMAL(10,2))


WHEN E.DeducIsssAfp = 0 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END)) * 0.00), DECIMAL(10,2))
END)
+
(CASE
WHEN ( CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END


/* PENSIONADOS 1 */

WHEN E.Pensionado = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END


/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.DeducIsssIpsfa = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.10), DECIMAL(10,2))
END) IS NULL THEN 0 ELSE
( CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.DeducIsssIpsfa = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END

/* PENSIONADOS 1 */

WHEN E.Pensionado = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.10), DECIMAL(10,2))
END) + (CASE WHEN (SELECT SUM(P.ISRPlanilla) ) IS NULL THEN 0 ELSE (SELECT SUM(P.ISRPlanilla) ) END)
END) +
CONVERT((CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2))  ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) )
END) ELSE 0.00 END)
+
(CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) )
END) ELSE 0.00 END)
+

(CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) )
END)ELSE 0.00 END),DECIMAL(10,2))
AS 'TOTALPERCEPCION',









/********************************** CALCULO ANTICIPOS ********************************/

(CASE WHEN (SELECT SUM(Anticipos)  )  IS NULL THEN 0.00 ELSE (SELECT SUM(Anticipos)
) END)

as 'ANTICIPOS',








/********************************** CALCULO SALARIO LIQUIDO ********************************/

(CASE WHEN

(CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Comision) ) END
+
CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.HorasExtras) ) END
+
CASE WHEN
(SELECT SUM(P.Bono) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Bono) ) END) IS NULL
THEN 0 ELSE
(CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Comision) ) END
+
CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.HorasExtras) ) END
+
CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Bono) ) END)

+ (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)END)

-
(CASE WHEN (SELECT SUM(Anticipos)  )  IS NULL THEN 0.00 ELSE (SELECT SUM(Anticipos)  )  END)

-

((CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
*
(SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
>= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
END

WHEN E.Pensionado = 1  THEN
CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+(CASE WHEN (SELECT SUM(P.Comision) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) ) END + CASE WHEN (SELECT SUM(P.Bono) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) ) END)) * 0.00), DECIMAL(10,2))


WHEN E.DeducIsssIpsfa = 1  THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))

<= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)

THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))

* (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END)) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1)
THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
END

WHEN E.NoDependiente = 1 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+(CASE WHEN (SELECT SUM(P.Comision) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Comision) ) END +
CASE WHEN (SELECT SUM(P.Bono) ) IS NULL THEN 0 ELSE (SELECT SUM(P.Bono) ) END)) * 0.00), DECIMAL(10,2))
END)

+

(CASE
WHEN E.DeducIsssIpsfa = 1 THEN
CASE
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1)), DECIMAL(10,2))
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoIpsfaSig FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1)), DECIMAL(10,2))
END
WHEN E.DeducIsssAfp = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))
WHEN E.NoDependiente = 0 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))
END)

+
(CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
END

WHEN E.Pensionado = 1 THEN
CASE
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
<= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
* (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
WHEN ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END))
>= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
END

WHEN E.DeducIsssAfp = 0 THEN CONVERT((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)+
  (CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
  (CASE WHEN (SELECT SUM(P.Comision) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.Comision) )
    END) ELSE 0.00 END)
    +
  (CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.HorasExtras) ) IS NULL
    THEN 0 ELSE (SELECT SUM(P.HorasExtras) )
    END) ELSE 0.00 END)
    +

  (CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 1) = 1 THEN
          (CASE WHEN (SELECT SUM(P.Bono) ) IS NULL
  THEN 0 ELSE (SELECT SUM(P.Bono) )
  END)ELSE 0.00 END)) * 0.00), DECIMAL(10,2))
END)

+

(CASE
WHEN ( CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.DeducIsssIpsfa = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* PENSIONADOS 1 */

WHEN E.Pensionado = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.10), DECIMAL(10,2))
END) IS NULL THEN 0 ELSE
( CASE
WHEN E.DeducIsssAfp = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.DeducIsssIpsfa = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END

/* PENSIONADOS 1 */

WHEN E.Pensionado = 1 THEN
CASE  /* TRAMO 1 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2))
>= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.03)), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.00), DECIMAL(10,2))

/* TRAMO 2 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 3 */
WHEN CONVERT( (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN
CASE
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
AND CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT(((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
)
- ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END
WHEN  CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) -
(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) <=
(SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

/* TRAMO 4 */
WHEN CONVERT((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) - (
((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))), DECIMAL(10,2)) >=
(SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')
AND (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT((((((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))

WHEN (CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
THEN CONVERT(((( ((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1))
- (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
* (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo'))
+ (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = '$Tipo')), DECIMAL(10,2))
END


/* CALCULO DE IPSFA CON ISSS PARA ISR */
WHEN E.NoDependiente = 1 THEN CONVERT(((CONVERT((E.SalarioNominal/2), DECIMAL(10,2)) -
CASE WHEN (SELECT SUM(P.Incapacidades) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Incapacidades) )
END  -

CASE WHEN (SELECT SUM(P.Permisos) )  IS NULL
  THEN 0.00 ELSE (SELECT SUM(P.Permisos) )
END
) * 0.10), DECIMAL(10,2))
END) + (CASE WHEN (SELECT SUM(P.ISRPlanilla) ) IS NULL THEN 0 ELSE (SELECT SUM(P.ISRPlanilla) ) END)
END)

) +
CONVERT((CASE WHEN (Select ComisionesConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2))  ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Comision) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) )
END) ELSE 0.00 END)
+
(CASE WHEN (Select HorasExtrasConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.HorasExtras) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) )
END) ELSE 0.00 END)
+

(CASE WHEN (Select BonosConfig from configuraciongeneral where IdConfiguracion = 0) = 0 THEN
(CASE WHEN (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) ) IS NULL
THEN 0 ELSE (SELECT SUM(P.Bono) * CONVERT((SELECT TramoAplicarPorcen FROM tramoisr WHERE IdTramoIsr = 2),DECIMAL(10,2)) )
END)ELSE 0.00 END),DECIMAL(10,2))
AS 'SALARIOLIQUIDO'

FROM Empleado E
LEFT JOIN Planilla P on E.IdEmpleado = P.IdEmpleado
LEFT JOIN puestoempresa pu on  E.IdPuestoEmpresa = pu.IdPuestoEmpresa
LEFT JOIN banco ba on e.IdBanco = ba.IdBanco
WHERE E.EmpleadoActivo = 1 and E.FechaDespido IS NULL AND E.NoDependiente = 0 and  P.FechaTransaccion between '$FechaIni' and '$FechaFin'
group by E.IdEmpleado
";

 $resultadoqueryplanilla = $mysqli->query($queryplanilla);
