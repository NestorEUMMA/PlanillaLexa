  <?php

  include '../../include/dbconnect.php';
  session_start();

      $IdEmpleado = $_POST["id"];


      $queryresultado = "SELECT E.IdEmpleado AS 'IDEMPLEADO', 

      CONVERT(E.SalarioNominal, DECIMAL(10,2)) AS 'SALARIONOMINAL',

   /* CALCULA EL AFP Y VALIDA SI ES MAYOR AL TECHO */
    CASE
    WHEN E.DeducIsssAfp = 1 THEN
    CASE
      WHEN E.SalarioNominal <= (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT((E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
      WHEN E.SalarioNominal >= (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1) THEN CONVERT(((SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1) * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)), DECIMAL(10,2))
    END
  WHEN E.DeducIsssAfp = 0 THEN CONVERT((E.SalarioNominal * 0.00), DECIMAL(10,2))
    END AS 'AFP',
 
    /* CALCULA EL ISSS Y VALIDA SI ES MAYOR AL TECHO */
    CASE
  WHEN E.DeducIsssAfp = 1 THEN
    CASE
      WHEN E.SalarioNominal <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT((E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
      WHEN E.SalarioNominal >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
    END
 WHEN E.DeducIsssIpsfa = 1  THEN
    CASE
      WHEN E.SalarioNominal <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT((E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
      WHEN E.SalarioNominal >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) THEN CONVERT(((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)), DECIMAL(10,2))
    END

   WHEN E.NoDependiente = 1 THEN CONVERT((E.SalarioNominal * 0.00), DECIMAL(10,2)) 
    END AS 'ISSS',
    
/* CALCULA EL IPSFA Y VALIDA SI ES MAYOR AL TECHO */
  CASE
     WHEN E.DeducIsssIpsfa = 1 THEN
    CASE
      WHEN E.SalarioNominal <= (SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT((E.SalarioNominal * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoipsfa = 1)), DECIMAL(10,2))
      WHEN E.SalarioNominal >= (SELECT TechoIpsfaSig FROM tramoipsfa WHERE IdTramoipsfa = 1) THEN CONVERT(((SELECT TechoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1) * (SELECT TramoIpsfa FROM tramoipsfa WHERE IdTramoIpsfa = 1)), DECIMAL(10,2))
    END
   WHEN E.DeducIsssAfp = 0 THEN CONVERT((E.SalarioNominal * 0.00), DECIMAL(10,2))
     WHEN E.NoDependiente = 0 THEN CONVERT((E.SalarioNominal * 0.00), DECIMAL(10,2))
    END AS 'IPSFA',
    
    /*CALCULA ISSSPREVISORIO, EN ESTE CASO SERIA 0.00 */
  CONVERT((E.SalarioNominal * 0.00), DECIMAL(10,2)) AS 'ISSSPREV',
    
  
    /*CALCULA EL ISR Y VALIDA LOS TRAMOS, TECHOS DE AFP E ISSS */
   CASE
     WHEN E.DeducIsssAfp = 1 THEN 
    CASE  /* TRAMO 1 */    
    WHEN CONVERT(E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) 
      >= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = 'MENSUAL') 
      AND CONVERT(E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + (E.SalarioNominal * 0.03)), DECIMAL(10,2)) <= 
          (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = 'MENSUAL') 
      THEN CONVERT((E.SalarioNominal * 0.00), DECIMAL(10,2))
        
      /* TRAMO 2 */
      WHEN CONVERT(E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >= 
      (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = 'MENSUAL') 
      AND CONVERT(E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <= 
          (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = 'MENSUAL') 
      THEN CONVERT((((E.SalarioNominal - (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)) 
      - (E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) 
          - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = 'MENSUAL')) 
          * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = 'MENSUAL')) 
          + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = 'MENSUAL')), DECIMAL(10,2))
      
      /* TRAMO 3 */
    WHEN CONVERT( E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >= 
      (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL') 
      AND E.SalarioNominal <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
      THEN 
        CASE
      WHEN CONVERT(E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >= 
        (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL') 
        AND CONVERT(E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <= 
        (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL') 
      THEN CONVERT((((E.SalarioNominal - (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)) 
        - (E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) 
        - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL')) 
        * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL')) 
        + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL')), DECIMAL(10,2)) 
          END
    WHEN E.SalarioNominal >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT(E.SalarioNominal - 
          ((E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <= 
          (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL') 
          THEN CONVERT((((E.SalarioNominal - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)) 
        - (E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) 
        - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL')) 
        * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL')) 
        + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL')), DECIMAL(10,2))
            
      /* TRAMO 4 */
    WHEN CONVERT(E.SalarioNominal - ( 
      (E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >= 
      (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL') 
      AND E.SalarioNominal <=  (SELECT TechoAfp FROM tramoafp WHERE IdTramoAfp = 1)
           THEN CONVERT((((E.SalarioNominal - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)) 
        - (E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) 
        - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL')) 
        * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL')) 
        + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL')), DECIMAL(10,2))
            
    WHEN E.SalarioNominal > (SELECT TechoAfpSig FROM tramoafp WHERE IdTramoAfp = 1)
           THEN CONVERT((((E.SalarioNominal - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)) 
        - (E.SalarioNominal * (SELECT TramoAfp FROM tramoafp WHERE IdTramoAfp = 1)) 
        - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL')) 
        * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL')) 
        + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL')), DECIMAL(10,2))
    END
     /* CALCULO DE IPSFA CON ISSS PARA ISR */
    WHEN E.DeducIsssIpsfa = 1 THEN 
    CASE  /* TRAMO 1 */    
    WHEN CONVERT(E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) 
      >= (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = 'MENSUAL') 
      AND CONVERT(E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + (E.SalarioNominal * 0.03)), DECIMAL(10,2)) <= 
          (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 1' AND TramoFormaPago = 'MENSUAL') 
      THEN CONVERT((E.SalarioNominal * 0.00), DECIMAL(10,2))
        
      /* TRAMO 2 */
      WHEN CONVERT(E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >= 
      (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = 'MENSUAL') 
      AND CONVERT(E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <= 
          (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = 'MENSUAL') 
      THEN CONVERT((((E.SalarioNominal - (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)) 
      - (E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) 
          - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = 'MENSUAL')) 
          * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = 'MENSUAL')) 
          + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 2' AND TramoFormaPago = 'MENSUAL')), DECIMAL(10,2))
      
      /* TRAMO 3 */
    WHEN CONVERT( E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >= 
      (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL') 
      AND E.SalarioNominal <= (SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1)
      THEN 
        CASE
      WHEN CONVERT(E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >= 
        (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL') 
        AND CONVERT(E.SalarioNominal - ((E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <= 
        (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL') 
      THEN CONVERT((((E.SalarioNominal - (E.SalarioNominal * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)) 
        - (E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) 
        - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL')) 
        * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL')) 
        + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL')), DECIMAL(10,2)) 
          END
    WHEN E.SalarioNominal >= (SELECT TechoSig FROM tramoisss WHERE IdTramoIsss = 1) AND CONVERT(E.SalarioNominal - 
          ((E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) <= 
          (SELECT TramoHasta FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL') 
          THEN CONVERT((((E.SalarioNominal - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)) 
        - (E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) 
        - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL')) 
        * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL')) 
        + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 3' AND TramoFormaPago = 'MENSUAL')), DECIMAL(10,2))
            
      /* TRAMO 4 */
    WHEN CONVERT(E.SalarioNominal - ( 
      (E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) + ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1))), DECIMAL(10,2)) >= 
      (SELECT TramoDesde FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL') 
      AND E.SalarioNominal <=  (SELECT TechoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
           THEN CONVERT((((E.SalarioNominal - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)) 
        - (E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) 
        - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL')) 
        * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL')) 
        + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL')), DECIMAL(10,2))
            
    WHEN E.SalarioNominal > (SELECT TechoIpsfaSig FROM TramoIpsfa WHERE IdTramoIpsfa = 1)
           THEN CONVERT((((E.SalarioNominal - ((SELECT TechoIsss FROM tramoisss WHERE IdTramoIsss = 1) * (SELECT TramoIsss FROM tramoisss WHERE IdTramoIsss = 1)) 
        - (E.SalarioNominal * (SELECT TramoIpsfa FROM TramoIpsfa WHERE IdTramoIpsfa = 1)) 
        - (SELECT TramoExceso FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL')) 
        * (SELECT TramoAplicarPorcen FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL')) 
        + (SELECT TramoCuota FROM tramoisr WHERE NumTramo = 'Tramo 4' AND TramoFormaPago = 'MENSUAL')), DECIMAL(10,2))
    END 
      /* CALCULO DE IPSFA CON ISSS PARA ISR */
    WHEN E.NoDependiente = 1 THEN CONVERT((E.SalarioNominal * 0.10), DECIMAL(10,2))
  END AS 'ISR'

    , CONVERT(E.SalarioNominal, DECIMAL(10,2)) as 'NETO'

  FROM empleado E
  WHERE E.IdEmpleado = $IdEmpleado";
  
     $resultadoexpedientesu = $mysqli->query($queryresultado);

     $datos = array();

              while ($test = $resultadoexpedientesu->fetch_assoc())
                    {
                        $datos["IDEMPLEADO"] = $test['IDEMPLEADO'];
                        $datos["SALARIONOMINAL"] = $test['SALARIONOMINAL'];
                        $datos["ISSS"] = $test['ISSS'];
                        $datos["AFP"] = $test['AFP'];
                        $datos["IPSFA"] = $test['IPSFA'];
                        $datos["ISR"] = $test['ISR'];
                        $datos["NETO"] = ($test['SALARIONOMINAL'] - $test['ISSS'] - $test['AFP'] - $test['ISR'] - $test['IPSFA']);
                    }

      header("Content-Type","application/json");

      print_r(json_encode($datos));

  ?>
