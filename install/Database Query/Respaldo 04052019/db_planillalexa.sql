-- MySQL dump 10.13  Distrib 5.7.12, for Win32 (AMD64)
--
-- Host: localhost    Database: db_planillalexa
-- ------------------------------------------------------
-- Server version	5.7.17-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accionpersonal`
--

DROP TABLE IF EXISTS `accionpersonal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accionpersonal` (
  `IdAccionPersonal` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `Motivo` varchar(1000) NOT NULL,
  `Descuento` decimal(10,2) NOT NULL,
  `FechaAccion` varchar(45) NOT NULL,
  `PeriodoAccion` varchar(45) NOT NULL,
  `MesAccion` varchar(45) NOT NULL,
  PRIMARY KEY (`IdAccionPersonal`),
  KEY `fk_accionpersonal_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_accionpersonal_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accionpersonal`
--

LOCK TABLES `accionpersonal` WRITE;
/*!40000 ALTER TABLE `accionpersonal` DISABLE KEYS */;
/*!40000 ALTER TABLE `accionpersonal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aguinaldos`
--

DROP TABLE IF EXISTS `aguinaldos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aguinaldos` (
  `IdAguinaldo` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `PeridoAguinaldo` int(4) NOT NULL,
  `FechaAguinaldo` date NOT NULL,
  `MontoAguinaldo` decimal(10,2) NOT NULL,
  PRIMARY KEY (`IdAguinaldo`),
  KEY `fk_aguinaldo_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_aguinaldo_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aguinaldos`
--

LOCK TABLES `aguinaldos` WRITE;
/*!40000 ALTER TABLE `aguinaldos` DISABLE KEYS */;
/*!40000 ALTER TABLE `aguinaldos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anticipos`
--

DROP TABLE IF EXISTS `anticipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anticipos` (
  `IdAnticipo` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `FechaAnticipos` date NOT NULL,
  `MontoAnticipo` decimal(10,2) NOT NULL,
  `MesPeriodoAnticipo` varchar(15) NOT NULL,
  `AnoPeriodoAnticipo` varchar(15) NOT NULL,
  PRIMARY KEY (`IdAnticipo`),
  KEY `fk_anticipos_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_anticipos_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anticipos`
--

LOCK TABLES `anticipos` WRITE;
/*!40000 ALTER TABLE `anticipos` DISABLE KEYS */;
/*!40000 ALTER TABLE `anticipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banco`
--

DROP TABLE IF EXISTS `banco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banco` (
  `IdBanco` int(11) NOT NULL AUTO_INCREMENT,
  `DescripcionBanco` varchar(45) NOT NULL,
  PRIMARY KEY (`IdBanco`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banco`
--

LOCK TABLES `banco` WRITE;
/*!40000 ALTER TABLE `banco` DISABLE KEYS */;
INSERT INTO `banco` VALUES (1,'Banco Agricola'),(2,'Banco Cuscatlan'),(3,'Banco Promerica'),(4,'Banco Davivienda'),(5,'Banco de America Central');
/*!40000 ALTER TABLE `banco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bonos`
--

DROP TABLE IF EXISTS `bonos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bonos` (
  `IdBono` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `MontoBono` decimal(10,2) NOT NULL,
  `MesPeriodoBono` varchar(15) NOT NULL,
  `AnoPeriodoBono` varchar(15) NOT NULL,
  `FechaBono` date NOT NULL,
  `ConceptoBono` varchar(500) NOT NULL,
  `MontoPagarBono` decimal(10,2) NOT NULL,
  `MontoISRBono` decimal(10,2) DEFAULT NULL,
  `ISSSBono` decimal(10,2) DEFAULT NULL,
  `AFPBono` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`IdBono`),
  KEY `fk_bono_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_bono_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bonos`
--

LOCK TABLES `bonos` WRITE;
/*!40000 ALTER TABLE `bonos` DISABLE KEYS */;
/*!40000 ALTER TABLE `bonos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogocuentas`
--

DROP TABLE IF EXISTS `catalogocuentas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogocuentas` (
  `IdCatalogoCuentas` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoCuentas` varchar(45) NOT NULL,
  `Descripcion` varchar(45) NOT NULL,
  `TipoCuenta` varchar(45) NOT NULL,
  PRIMARY KEY (`IdCatalogoCuentas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogocuentas`
--

LOCK TABLES `catalogocuentas` WRITE;
/*!40000 ALTER TABLE `catalogocuentas` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogocuentas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `codigoobservacion`
--

DROP TABLE IF EXISTS `codigoobservacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `codigoobservacion` (
  `IdCodigoObservacion` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(45) NOT NULL,
  `DescripcionCodigo` varchar(45) NOT NULL,
  PRIMARY KEY (`IdCodigoObservacion`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `codigoobservacion`
--

LOCK TABLES `codigoobservacion` WRITE;
/*!40000 ALTER TABLE `codigoobservacion` DISABLE KEYS */;
INSERT INTO `codigoobservacion` VALUES (1,'0','0 - SIN CAMBIOS'),(2,'1','1 - PAGOS ADICIONALES'),(3,'2','2 - APRENDICES'),(4,'3','3 - PENSIONADOS'),(5,'5 ','5 - INCAPACIDAD'),(6,'6','6 - RETIRO DEL TRABAJADOR DE LA EMPRESA'),(7,'7','7 - INGRESO O REINGRESO DEL TRABAJADOR'),(8,'8','8 - VACACIONES'),(9,'9','9 - VACACIONES MAS PAGOS ADICIONALES');
/*!40000 ALTER TABLE `codigoobservacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `codigoreporteanual`
--

DROP TABLE IF EXISTS `codigoreporteanual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `codigoreporteanual` (
  `CodigoIngreso` varchar(11) NOT NULL,
  `Descripcion` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`CodigoIngreso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `codigoreporteanual`
--

LOCK TABLES `codigoreporteanual` WRITE;
/*!40000 ALTER TABLE `codigoreporteanual` DISABLE KEYS */;
INSERT INTO `codigoreporteanual` VALUES ('01','01 SERVICIOS DE CARACTER PERMANENTE CON SUBORDINACION O DEPENDENCIA LABORAL'),('05','05 RENTAS DE PERSONAS JURIDICAS DOMICILIADAS PROVENIENTES DE DEPOSITO DE DINERO'),('06','06 RENTAS DE PERSONAS JURIDICAS DOMICILIADAS PROVENIENTES DE TITULOS VALORES'),('07','07 RETENCIONES POR ACTIVIDADES AGROPECUARIAS'),('08','08 RETENCIONES POR JUICIOS EJECUTIVOS'),('09','09 OTRAS RETENCIONES ACREDITABLES'),('11','11 SERVICIOS SIN DEPENDENCIA LABORAL');
/*!40000 ALTER TABLE `codigoreporteanual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `codigosepp`
--

DROP TABLE IF EXISTS `codigosepp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `codigosepp` (
  `CodigoSepp` varchar(2) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`CodigoSepp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `codigosepp`
--

LOCK TABLES `codigosepp` WRITE;
/*!40000 ALTER TABLE `codigosepp` DISABLE KEYS */;
INSERT INTO `codigosepp` VALUES ('1','1 INGRESO'),('2','2 RETIRO'),('3','3 LICENCIA'),('4','4 INCAPACIDAD'),('5','5 APRENDIZ'),('6','6 PENSIONADO O TRABAJADOR COTIZANTE QUE YA RECIBIO DEVOLUCIÓN DE SALDO POR VEJEZ'),('7','7 CON EDAD LEGAL DE VEJEZ'),('9','9 DOCENTE PUBLICO');
/*!40000 ALTER TABLE `codigosepp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comisiones`
--

DROP TABLE IF EXISTS `comisiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comisiones` (
  `IdComisiones` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `MontoComision` decimal(10,2) NOT NULL,
  `MesPeriodoComi` varchar(45) NOT NULL,
  `AnoPeriodoComi` varchar(45) NOT NULL,
  `IdParametro` int(11) NOT NULL,
  `ConceptoComision` varchar(500) NOT NULL,
  `ComisionPagar` decimal(10,2) NOT NULL,
  `FechaComision` date DEFAULT NULL,
  `MontoISRComosiones` decimal(10,2) DEFAULT NULL,
  `ComisionAFP` decimal(10,2) DEFAULT NULL,
  `ComisionISSS` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`IdComisiones`),
  KEY `fk_comisiones_empleado1_idx` (`IdEmpleado`),
  KEY `fk_comisiones_parametro1_idx` (`IdParametro`),
  CONSTRAINT `fk_comisiones_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comisiones_parametro1` FOREIGN KEY (`IdParametro`) REFERENCES `parametros` (`IdParametro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comisiones`
--

LOCK TABLES `comisiones` WRITE;
/*!40000 ALTER TABLE `comisiones` DISABLE KEYS */;
/*!40000 ALTER TABLE `comisiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuraciongeneral`
--

DROP TABLE IF EXISTS `configuraciongeneral`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuraciongeneral` (
  `IdConfiguracion` int(11) NOT NULL AUTO_INCREMENT,
  `SalarioMinimo` decimal(10,2) NOT NULL,
  `ComisionesConfig` bit(1) NOT NULL,
  `HorasExtrasConfig` bit(1) NOT NULL,
  `BonosConfig` bit(1) NOT NULL,
  `HonorariosConfig` bit(1) NOT NULL,
  PRIMARY KEY (`IdConfiguracion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuraciongeneral`
--

LOCK TABLES `configuraciongeneral` WRITE;
/*!40000 ALTER TABLE `configuraciongeneral` DISABLE KEYS */;
INSERT INTO `configuraciongeneral` VALUES (1,304.52,'','','','\0');
/*!40000 ALTER TABLE `configuraciongeneral` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deduccionempleado`
--

DROP TABLE IF EXISTS `deduccionempleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deduccionempleado` (
  `IdDeduccionEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `SueldoEmpleado` decimal(10,2) NOT NULL,
  `DeducAfp` decimal(10,2) DEFAULT NULL,
  `DeducIsss` decimal(10,2) DEFAULT NULL,
  `DeducIsr` decimal(10,2) DEFAULT NULL,
  `DeducIpsfa` decimal(10,2) DEFAULT NULL,
  `SueldoNeto` decimal(10,2) DEFAULT NULL,
  `FechaCalculo` date DEFAULT NULL,
  PRIMARY KEY (`IdDeduccionEmpleado`),
  KEY `fk_deduccionempleado_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_deduccionempleado_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deduccionempleado`
--

LOCK TABLES `deduccionempleado` WRITE;
/*!40000 ALTER TABLE `deduccionempleado` DISABLE KEYS */;
/*!40000 ALTER TABLE `deduccionempleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamentoempresa`
--

DROP TABLE IF EXISTS `departamentoempresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamentoempresa` (
  `IdDepartamentoEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `DescripcionDepartamentoEmpresa` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`IdDepartamentoEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamentoempresa`
--

LOCK TABLES `departamentoempresa` WRITE;
/*!40000 ALTER TABLE `departamentoempresa` DISABLE KEYS */;
INSERT INTO `departamentoempresa` VALUES (1,'ADMINISTRACION'),(2,'BAR Y RESTAURANTE'),(3,'MANTENIMIENTO'),(4,'CONTABILIDAD'),(5,'MERCADEO'),(6,'VENTAS'),(7,'HABITACIONES'),(8,'COCINA'),(9,'GERENCIA GENERAL');
/*!40000 ALTER TABLE `departamentoempresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamentos` (
  `IdDepartamentos` varchar(45) NOT NULL,
  `NombreDepartamento` varchar(45) NOT NULL,
  PRIMARY KEY (`IdDepartamentos`),
  CONSTRAINT `fk_deparatmentos_municipios1` FOREIGN KEY (`IdDepartamentos`) REFERENCES `municipios` (`IdDepartamentos`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamentos`
--

LOCK TABLES `departamentos` WRITE;
/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;
INSERT INTO `departamentos` VALUES ('01','AHUACHAPAN'),('02','SANTA ANA'),('03','SONSONATE'),('04','CHALATENANGO'),('05','LA LIBERTAD'),('06','SAN SALVADOR'),('07','CUSCATLAN'),('08','LA PAZ'),('09','CABANAS'),('10','SAN VICENTE'),('11','USULUTAN'),('12','SAN MIGUEL'),('13','MORAZAN'),('14','LA UNION');
/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado`
--

DROP TABLE IF EXISTS `empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empleado` (
  `IdEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `Nup` varchar(45) DEFAULT NULL,
  `IdTipoDocumento` int(11) DEFAULT NULL,
  `NumTipoDocumento` varchar(45) DEFAULT NULL,
  `DuiExpedido` varchar(100) DEFAULT NULL,
  `DuiEl` varchar(45) DEFAULT NULL,
  `DuiDe` varchar(45) DEFAULT NULL,
  `IdInstitucionPre` int(11) DEFAULT NULL,
  `Genero` varchar(45) DEFAULT NULL,
  `PrimerNomEmpleado` varchar(45) NOT NULL,
  `SegunNomEmpleado` varchar(45) DEFAULT NULL,
  `PrimerApellEmpleado` varchar(45) NOT NULL,
  `SegunApellEmpleado` varchar(45) DEFAULT NULL,
  `ApellidoCasada` varchar(45) DEFAULT NULL,
  `ConocidoPor` varchar(45) DEFAULT NULL,
  `IdTipoEmpleado` int(11) NOT NULL,
  `IdEstadoCivil` int(11) NOT NULL,
  `FNacimiento` date DEFAULT NULL,
  `NIsss` varchar(45) DEFAULT NULL,
  `MIpsfa` varchar(45) DEFAULT NULL,
  `Nit` varchar(25) DEFAULT NULL,
  `SalarioNominal` decimal(10,2) DEFAULT NULL,
  `IdPuestoEmpresa` int(11) DEFAULT NULL,
  `Direccion` varchar(45) DEFAULT NULL,
  `IdDepartamentos` varchar(45) DEFAULT NULL,
  `IdMunicipios` varchar(45) DEFAULT NULL,
  `CorreoElectronico` varchar(45) DEFAULT NULL,
  `TelefonoEmpleado` varchar(45) DEFAULT NULL,
  `CelularEmpleado` varchar(45) DEFAULT NULL,
  `CBancaria` varchar(45) DEFAULT NULL,
  `IdBanco` int(11) DEFAULT NULL,
  `JefeInmediato` int(11) DEFAULT NULL,
  `CasoEmergencia` varchar(45) DEFAULT NULL,
  `TeleCasoEmergencia` varchar(45) DEFAULT NULL,
  `Dependiente1` varchar(100) DEFAULT NULL,
  `FNacimientoDep1` date DEFAULT NULL,
  `Dependiente2` varchar(100) DEFAULT NULL,
  `FNacimientoDep2` date DEFAULT NULL,
  `Dependiente3` varchar(100) DEFAULT NULL,
  `FNacimientoDep3` date DEFAULT NULL,
  `Beneficiario` varchar(100) DEFAULT NULL,
  `DocumentBeneficiario` varchar(45) DEFAULT NULL,
  `NDocBeneficiario` varchar(45) DEFAULT NULL,
  `DeducIsssAfp` bit(1) DEFAULT NULL,
  `NoDependiente` bit(1) DEFAULT NULL,
  `EmpleadoActivo` bit(1) DEFAULT NULL,
  `FechaContratacion` date DEFAULT NULL,
  `FechaDespido` date DEFAULT NULL,
  `DeducIsssIpsfa` bit(1) DEFAULT NULL,
  `EmpleadoImagen` varchar(200) DEFAULT NULL,
  `IdDepartamentoEmpresa` int(11) DEFAULT NULL,
  `Profesion` varchar(100) DEFAULT NULL,
  `OtrosDatos` varchar(500) DEFAULT NULL,
  `HerramientasTrabajo` varchar(500) DEFAULT NULL,
  `Pensionado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`IdEmpleado`),
  KEY `fk_empleado_tipodocumento_idx` (`IdTipoDocumento`),
  KEY `fk_empleado_institucionprevisional1_idx` (`IdInstitucionPre`),
  KEY `fk_empleado_tipoempleado1_idx` (`IdTipoEmpleado`),
  KEY `fk_empleado_estadocivil1_idx` (`IdEstadoCivil`),
  KEY `fk_empleado_puestoempresa1_idx` (`IdPuestoEmpresa`),
  KEY `fk_empleado_banco1_idx` (`IdBanco`),
  KEY `fk_empleado_municipios_idx` (`IdMunicipios`),
  KEY `fk_empleado_departamentos1_idx` (`IdDepartamentos`),
  KEY `fk_empleado_departamentoempresa1_idx` (`IdDepartamentoEmpresa`),
  CONSTRAINT `fk_empleado_banco1` FOREIGN KEY (`IdBanco`) REFERENCES `banco` (`IdBanco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_departamentoempresa1` FOREIGN KEY (`IdDepartamentoEmpresa`) REFERENCES `departamentoempresa` (`IdDepartamentoEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_departamentos1` FOREIGN KEY (`IdDepartamentos`) REFERENCES `departamentos` (`IdDepartamentos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_estadocivil1` FOREIGN KEY (`IdEstadoCivil`) REFERENCES `estadocivil` (`IdEstadoCivil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_institucionprevisional1` FOREIGN KEY (`IdInstitucionPre`) REFERENCES `institucionprevisional` (`IdInstitucionPre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_municipios1` FOREIGN KEY (`IdMunicipios`) REFERENCES `municipios` (`IdMunicipios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_puestoempresa1` FOREIGN KEY (`IdPuestoEmpresa`) REFERENCES `puestoempresa` (`IdPuestoEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_tipodocumento1` FOREIGN KEY (`IdTipoDocumento`) REFERENCES `tipodocumento` (`IdTipoDocumento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleado_tipoempleado1` FOREIGN KEY (`IdTipoEmpleado`) REFERENCES `tipoempleado` (`IdTipoEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado`
--

LOCK TABLES `empleado` WRITE;
/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` VALUES (1,'000000000000',1,'000000000','','','',NULL,'Masculino','NESTOR','','ULLOA','','','',1,2,NULL,'','','0000-000000-000-0',850.00,NULL,'','01',NULL,'','','','',NULL,NULL,'','','',NULL,'',NULL,'',NULL,'','Seleccione...','','','\0','','2018-11-01',NULL,'\0','uploads/empleados/NESTORULLOA.jpg',1,'INGENIERO','','','\0');
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `IdEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `NombreEmpresa` varchar(45) DEFAULT NULL,
  `Direccion` varchar(500) DEFAULT NULL,
  `IdDepartamentos` varchar(45) DEFAULT NULL,
  `IdMunicipios` varchar(45) DEFAULT NULL,
  `GiroFiscal` varchar(100) DEFAULT NULL,
  `NrcEmpresa` varchar(45) DEFAULT NULL,
  `NitEmpresa` varchar(45) DEFAULT NULL,
  `IdEmpleado` int(11) DEFAULT NULL,
  `EmpleadoActivo` varchar(45) DEFAULT NULL,
  `NuPatronal` varchar(45) DEFAULT NULL,
  `ImagenEmpresa` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`IdEmpresa`),
  KEY `fk_empresa_departamentos1_idx` (`IdDepartamentos`),
  KEY `fk_empresa_municipios1_idx` (`IdMunicipios`),
  KEY `fk_empresa_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_empresa_departamentos1` FOREIGN KEY (`IdDepartamentos`) REFERENCES `departamentos` (`IdDepartamentos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_empresa_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_empresa_municipios1` FOREIGN KEY (`IdMunicipios`) REFERENCES `municipios` (`IdMunicipios`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estadocivil`
--

DROP TABLE IF EXISTS `estadocivil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estadocivil` (
  `IdEstadoCivil` int(11) NOT NULL AUTO_INCREMENT,
  `DescripcionEstadoCivil` varchar(45) NOT NULL,
  PRIMARY KEY (`IdEstadoCivil`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadocivil`
--

LOCK TABLES `estadocivil` WRITE;
/*!40000 ALTER TABLE `estadocivil` DISABLE KEYS */;
INSERT INTO `estadocivil` VALUES (1,'Soltero/a'),(2,'Casado/a'),(3,'Divorciado/a'),(4,'Acompañado/a'),(5,'Viudo/a');
/*!40000 ALTER TABLE `estadocivil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `honorario`
--

DROP TABLE IF EXISTS `honorario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `honorario` (
  `IdHonorario` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `MontoHonorario` decimal(10,2) NOT NULL,
  `IdParametro` int(11) NOT NULL,
  `ConceptoHonorario` varchar(500) NOT NULL,
  `FechaHonorario` date NOT NULL,
  `MesPeriodoHono` varchar(15) NOT NULL,
  `AnoPeriodoHono` varchar(15) NOT NULL,
  `MontoPagar` decimal(10,2) NOT NULL,
  `MontoISRHonorarios` decimal(10,2) DEFAULT NULL,
  `ISSSHonorario` decimal(10,2) DEFAULT NULL,
  `AFPHonorario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`IdHonorario`),
  KEY `fk_honorario_empleado1_idx` (`IdEmpleado`),
  KEY `fk_honorario_parametro1_idx` (`IdParametro`),
  CONSTRAINT `fk_honorario_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_honorario_parametro1` FOREIGN KEY (`IdParametro`) REFERENCES `parametros` (`IdParametro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `honorario`
--

LOCK TABLES `honorario` WRITE;
/*!40000 ALTER TABLE `honorario` DISABLE KEYS */;
/*!40000 ALTER TABLE `honorario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horario`
--

DROP TABLE IF EXISTS `horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horario` (
  `IdHorario` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `JornadaLaboral` varchar(15) NOT NULL,
  `DiaLaboral` varchar(15) NOT NULL,
  `EntradaLaboral` varchar(15) NOT NULL,
  `SalidaLaboral` varchar(15) NOT NULL,
  PRIMARY KEY (`IdHorario`),
  KEY `fk_horario_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_horario_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horario`
--

LOCK TABLES `horario` WRITE;
/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
/*!40000 ALTER TABLE `horario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horasextras`
--

DROP TABLE IF EXISTS `horasextras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horasextras` (
  `IdHorasExtras` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `MesPeriodoHorasExt` varchar(15) NOT NULL,
  `AnoPeriodoHorasExt` varchar(15) NOT NULL,
  `MontoHorasExtras` decimal(10,2) NOT NULL,
  `FechaHorasExtras` date NOT NULL,
  `TipoHoraExtra` varchar(45) NOT NULL,
  `MontoISRHorasExtras` decimal(10,2) DEFAULT NULL,
  `MontoHorasExtrasTot` decimal(10,2) DEFAULT NULL,
  `CantidadHorasExtras` varchar(5) DEFAULT NULL,
  `HorasAFP` decimal(10,2) DEFAULT NULL,
  `HorasISSS` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`IdHorasExtras`),
  KEY `fk_horasextras_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_horasextras_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horasextras`
--

LOCK TABLES `horasextras` WRITE;
/*!40000 ALTER TABLE `horasextras` DISABLE KEYS */;
/*!40000 ALTER TABLE `horasextras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incapacidad`
--

DROP TABLE IF EXISTS `incapacidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incapacidad` (
  `IdIncapacidad` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) DEFAULT NULL,
  `DiasIncapacidad` varchar(45) DEFAULT NULL,
  `SalarioDescuento` decimal(10,2) DEFAULT NULL,
  `FechaIncapacidad` date DEFAULT NULL,
  `PeriodoIncapacidad` varchar(45) DEFAULT NULL,
  `MesIncapacidad` varchar(45) DEFAULT NULL,
  `DescripcionIncapacidad` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`IdIncapacidad`),
  KEY `fk_incapacidad_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_incapacidad_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incapacidad`
--

LOCK TABLES `incapacidad` WRITE;
/*!40000 ALTER TABLE `incapacidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `incapacidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `indemnizacion`
--

DROP TABLE IF EXISTS `indemnizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indemnizacion` (
  `IdIndemnizacion` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `FechaIndemnizacion` date NOT NULL,
  `MesPeriodoIndem` varchar(15) NOT NULL,
  `AnoPeriodoIndem` varchar(15) NOT NULL,
  `MontoIndemnizacion` decimal(10,2) NOT NULL,
  PRIMARY KEY (`IdIndemnizacion`),
  KEY `fk_indemnizacion_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_indemnizacion_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indemnizacion`
--

LOCK TABLES `indemnizacion` WRITE;
/*!40000 ALTER TABLE `indemnizacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `indemnizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institucionprevisional`
--

DROP TABLE IF EXISTS `institucionprevisional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institucionprevisional` (
  `IdInstitucionPre` int(11) NOT NULL AUTO_INCREMENT,
  `DescripcionInstitucion` varchar(60) NOT NULL,
  PRIMARY KEY (`IdInstitucionPre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institucionprevisional`
--

LOCK TABLES `institucionprevisional` WRITE;
/*!40000 ALTER TABLE `institucionprevisional` DISABLE KEYS */;
INSERT INTO `institucionprevisional` VALUES (1,'AFP Confia'),(2,'AFP Crecer'),(3,'IPSFA');
/*!40000 ALTER TABLE `institucionprevisional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `integracionpeachtree`
--

DROP TABLE IF EXISTS `integracionpeachtree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `integracionpeachtree` (
  `IdIntPeach` int(11) NOT NULL AUTO_INCREMENT,
  `Date` varchar(25) DEFAULT NULL,
  `Reference` varchar(25) DEFAULT NULL,
  `DateBankRec` decimal(10,2) DEFAULT NULL,
  `Account` varchar(45) DEFAULT NULL,
  `Description` varchar(45) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `JobID` varchar(45) DEFAULT NULL,
  `UsedReimbursable` varchar(45) DEFAULT NULL,
  `TransactionPeriod` varchar(45) DEFAULT NULL,
  `TransactionNumber` varchar(45) DEFAULT NULL,
  `CosolidatedTransaction` varchar(45) DEFAULT NULL,
  `RecurNumber` varchar(45) DEFAULT NULL,
  `RecurFrequency` varchar(45) DEFAULT NULL,
  `Mes` varchar(45) NOT NULL,
  `Periodo` varchar(45) NOT NULL,
  `Quincena` varchar(45) NOT NULL,
  `dependiente` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`IdIntPeach`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `integracionpeachtree`
--

LOCK TABLES `integracionpeachtree` WRITE;
/*!40000 ALTER TABLE `integracionpeachtree` DISABLE KEYS */;
/*!40000 ALTER TABLE `integracionpeachtree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `IdMenu` int(11) NOT NULL AUTO_INCREMENT,
  `DescripcionMenu` varchar(45) NOT NULL,
  `Icono` varchar(400) NOT NULL,
  `TipoMenu` varchar(45) NOT NULL,
  PRIMARY KEY (`IdMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'MENU LEXA','code','Menu'),(2,'LEXA','settings','Menu'),(3,'ADMINISTRACION','assessment','Menu'),(4,'MANTENIMIENTOS','assignment turned in','Menu'),(5,'TAREAS','assignment','Menu'),(6,'PERCEPCIONES','work','Menu'),(7,'REPORTES','list_alt','Menu'),(8,'INDEX','stars','Menu'),(9,'PERMISOS','assignment','Menu');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menudetalle`
--

DROP TABLE IF EXISTS `menudetalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menudetalle` (
  `IdMenuDetalle` int(11) NOT NULL AUTO_INCREMENT,
  `IdMenu` int(11) NOT NULL,
  `DescripcionMenuDetalle` varchar(400) DEFAULT NULL,
  `Url` varchar(400) DEFAULT NULL,
  `Icono` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`IdMenuDetalle`),
  KEY `fk_menudetalle_menu_idx` (`IdMenu`),
  CONSTRAINT `fk_menudetalle_menu1` FOREIGN KEY (`IdMenu`) REFERENCES `menu` (`IdMenu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=230 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menudetalle`
--

LOCK TABLES `menudetalle` WRITE;
/*!40000 ALTER TABLE `menudetalle` DISABLE KEYS */;
INSERT INTO `menudetalle` VALUES (1,1,'Menu','../menu/index','ME'),(2,1,'Menu Detalle','../menudetalle/index','MD'),(3,1,'Menu Usuario ADMIN','../menuusuarioadmin/index','MSA'),(4,1,'Puesto Usuarios','../puesto/index','PU'),(5,2,'Banco','../banco/index','BA'),(6,2,'Codigo de Ingreso F910','../codigoreporteanual/index','CR'),(7,2,'Codigo Observacion OVISSS','../codigoobservacion/index','CO'),(8,2,'Codigo Observacion SEPP','../codigosepp/index','CS'),(9,2,'Configuracion General','../configuraciongeneral/index','CG'),(10,2,'Datos Empresa','../empresa/index','DE'),(11,2,'Departamentos','../departamentos/index','DE'),(12,2,'Estado Civil','../estadocivil/index','EC'),(13,2,'Instituciones Previsional','../institucionprevisional/index','IP'),(14,2,'Municipios','../municipios/index','MU'),(15,2,'Tipo de Documento','../tipodocumento/index','TD'),(16,2,'Tipo de Empleado','../tipoempleado/index','TE'),(17,2,'Tramo AFP','../tramoafp/index','TA'),(18,2,'Tramo IPSFA','../tramoipsfa/index','TF'),(19,2,'Tramo ISR','../tramoisr/index','TI'),(20,2,'Tramo ISSS','../tramoisss/index','TS'),(21,3,'Empleado','../empleado/index','EM'),(22,3,'Horarios','../horario/index','HO'),(23,3,'Menu Usuario','../menuusuario/index','MS'),(24,3,'Permisos de Menu','../menupermiso/index','PM'),(25,3,'Usuarios','../usuario/index','US'),(26,4,'Catalogo de Cuentas','../catalogocuentas/index','CC'),(27,4,'Departamentos Empresariales','../departamentoempresa/index','DE'),(28,4,'Puesto Laboral','../puestoempresa/index','PL'),(29,4,'Resumen de Planilla','../planillamoviemiento/index','PM'),(30,5,'Generar Planilla','../planilla/index','PA'),(31,5,'OVISSS','../ovisss/index.php','OV'),(32,5,'Peachtree No Dependiente','../integracionnodependiente/index.php','IP'),(33,5,'Peachtree Planilla','../integracion/index.php','IP'),(34,6,'Accion Personal','../accionpersonal/index','AP'),(35,6,'Aguinaldos','../aguinaldos/index','AG'),(36,6,'Anticipos','../anticipos/index','AN'),(37,6,'Bonos','../bonos/index','BO'),(38,6,'Comision','../comisiones/index','CM'),(39,6,'Honorarios','../honorario/index','HN'),(40,6,'Horas Extras','../horasextras/index','HE'),(41,6,'Incapacidades','../incapacidad/index','IC'),(42,6,'Indemnizacion','../indemnizacion/index','ID'),(43,6,'Permisos','../permiso/index','PE'),(44,6,'Propinas','../propinas/index','PP'),(45,6,'Vacaciones','../vacaciones/index','VA'),(46,7,'Carta Renuncia','../cartarenuncia/index.php','CR'),(47,7,'Constancia Dependiente','../constanciadependiente/index','CD'),(48,7,'Constancia no Dependiente','../constancianodependiente/index','CN'),(49,7,'Planilla no Dependiente','../planillanodependiente/index.php','PD'),(50,7,'Planilla Sueldo','../parametrosplanilla/index','PS'),(51,7,'Reporte Accion Personal','../accionpersonalreporte/index.php','AP'),(52,7,'Reporte de Propinas','../propinasreporte/index.php','PR'),(53,7,'Reporte F910 Anual','../reporteanuarenta/index','RA'),(54,7,'Reporte SEPP','../reportesepp/index','RS'),(55,8,'Index','../site/index','IN'),(56,9,'Accion Personal  Create','../accionpersonal/create','ADMIN'),(57,9,'Accion Personal  Delete','../accionpersonal/delete','ADMIN'),(58,9,'Accion Personal  Report','../accionpersonal/report','ADMIN'),(59,9,'Accion Personal  Update','../accionpersonal/update','ADMIN'),(60,9,'Accion Personal  View','../accionpersonal/view','ADMIN'),(61,9,'Aguinaldos Create','../aguinaldos/create','ADMIN'),(62,9,'Aguinaldos Delete','../aguinaldos/delete','ADMIN'),(63,9,'Aguinaldos Report','../aguinaldos/report','ADMIN'),(64,9,'Aguinaldos Update','../aguinaldos/update','ADMIN'),(65,9,'Aguinaldos View','../aguinaldos/view','ADMIN'),(66,9,'Anticipos Create','../anticipos/create','ADMIN'),(67,9,'Anticipos Delete','../anticipos/delete','ADMIN'),(68,9,'Anticipos Report','../anticipos/report','ADMIN'),(69,9,'Anticipos Update','../anticipos/update','ADMIN'),(70,9,'Anticipos View','../anticipos/view','ADMIN'),(71,9,'Banco Create','../banco/create','LEXA'),(72,9,'Banco Delete','../banco/delete','LEXA'),(73,9,'Banco Update','../banco/update','LEXA'),(74,9,'Banco View','../banco/view','LEXA'),(75,9,'Bono Create','../bonos/create','ADMIN'),(76,9,'Bono Delete','../bonos/delete','ADMIN'),(77,9,'Bono Report','../bonos/report','ADMIN'),(78,9,'Bono Update','../bonos/update','ADMIN'),(79,9,'Bono View','../bonos/view','ADMIN'),(80,9,'CatalogoCuentas Create','../catalogocuentas/create','ADMIN'),(81,9,'CatalogoCuentas Delete','../catalogocuentas/delete','ADMIN'),(82,9,'CatalogoCuentas Update','../catalogocuentas/update','ADMIN'),(83,9,'CatalogoCuentas View','../catalogocuentas/view','ADMIN'),(84,9,'Codigo de Ingreso F910 Create','../codigoreporteanual/create','LEXA'),(85,9,'Codigo de Ingreso F910 Delete','../codigoreporteanual/delete','LEXA'),(86,9,'Codigo de Ingreso F910 Update','../codigoreporteanual/update','LEXA'),(87,9,'Codigo de Ingreso F910 View','../codigoreporteanual/view','LEXA'),(88,9,'Codigo Observacion Create','../codigoobservacion/create','LEXA'),(89,9,'Codigo Observacion Delete','../codigoobservacion/delete','LEXA'),(90,9,'Codigo Observacion SEPP Create','../codigosepp/create','LEXA'),(91,9,'Codigo Observacion SEPP Delete','../codigosepp/delete','LEXA'),(92,9,'Codigo Observacion SEPP Update','../codigosepp/update','LEXA'),(93,9,'Codigo Observacion SEPP View','../codigosepp/view','LEXA'),(94,9,'Codigo Observacion Update','../codigoobservacion/update','LEXA'),(95,9,'Codigo Observacion View','../codigoobservacion/view','LEXA'),(96,9,'Comisiones  Delete','../comisiones/delete','ADMIN'),(97,9,'Comisiones  Report','../comisiones/report','ADMIN'),(98,9,'Comisiones Create','../comisiones/create','ADMIN'),(99,9,'Comisiones Update','../comisiones/update','ADMIN'),(100,9,'Comisiones View','../comisiones/view','ADMIN'),(101,9,'Configuracion General Create','../configuraciongeneral/create','LEXA'),(102,9,'Configuracion General Update','../configuraciongeneral/update','LEXA'),(103,9,'Configuracion General View','../configuraciongeneral/view','LEXA'),(104,9,'Constancia Dependiente Report','../constanciadependiente/report','ADMIN'),(105,9,'Constancia Dependiente View','../constanciadependiente/view','ADMIN'),(106,9,'Constancia No Dependiente Report','../constancianodependiente/report','ADMIN'),(107,9,'Departamentos Create','../departamentos/create','LEXA'),(108,9,'Departamentos Delete','../departamentos/delete','LEXA'),(109,9,'Departamentos Empresariales Create','../departamentoempresa/create','ADMIN'),(110,9,'Departamentos Empresariales Delete','../departamentoempresa/delete','ADMIN'),(111,9,'Departamentos Empresariales Update','../departamentoempresa/update','ADMIN'),(112,9,'Departamentos Empresariales View','../departamentoempresa/view','ADMIN'),(113,9,'Departamentos Update','../departamentos/update','LEXA'),(114,9,'Departamentos View','../departamentos/view','LEXA'),(115,9,'Empleado Create','../empleado/create','ADMIN'),(116,9,'Empleado Delete','../empleado/delete','ADMIN'),(117,9,'Empleado Update','../empleado/update','ADMIN'),(118,9,'Empleado View','../empleado/view','ADMIN'),(119,9,'Empresa Create','../empresa/create','ADMIN'),(120,9,'Empresa Delete','../empresa/delete','ADMIN'),(121,9,'Empresa Update','../empresa/update','ADMIN'),(122,9,'Empresa View','../empresa/view','ADMIN'),(123,9,'Estado Civil Create','../estadocivil/create','LEXA'),(124,9,'Estado Civil Delete','../estadocivil/delete','LEXA'),(125,9,'Estado Civil Update','../estadocivil/update','LEXA'),(126,9,'Estado Civil View','../estadocivil/view','LEXA'),(127,9,'Honorario Create','../honorario/create','ADMIN'),(128,9,'Honorario Delete','../honorario/delete','ADMIN'),(129,9,'Honorario Report','../honorario/report','ADMIN'),(130,9,'Honorario Update','../honorario/update','ADMIN'),(131,9,'Honorario View','../honorario/view','ADMIN'),(132,9,'Horario Create','../horario/create','ADMIN'),(133,9,'Horario Delete','../horario/delete','ADMIN'),(134,9,'Horario Update','../horario/update','ADMIN'),(135,9,'Horario View','../horario/view','ADMIN'),(136,9,'HorasExtras Create','../horasextras/create','ADMIN'),(137,9,'HorasExtras Delete','../horasextras/delete','ADMIN'),(138,9,'HorasExtras Report','../horasextras/report','ADMIN'),(139,9,'HorasExtras Update','../horasextras/update','ADMIN'),(140,9,'HorasExtras View','../horasextras/view','ADMIN'),(141,9,'Incapacidad Create','../incapacidad/create','ADMIN'),(142,9,'Incapacidad Delete','../incapacidad/delete','ADMIN'),(143,9,'Incapacidad Update','../incapacidad/update','ADMIN'),(144,9,'Incapacidad View','../incapacidad/view','ADMIN'),(145,9,'Institucion Previsional Create','../institucionprevisional/create','LEXA'),(146,9,'Institucion Previsional Delete','../institucionprevisional/delete','LEXA'),(147,9,'Institucion Previsional Update','../institucionprevisional/update','LEXA'),(148,9,'Institucion Previsional View','../institucionprevisional/view','LEXA'),(149,9,'Menu Create','../menu/create','LEXA'),(150,9,'Menu Delete','../menu/Delete','LEXA'),(151,9,'Menu Detalle Create','../menudetalle/create','LEXA'),(152,9,'Menu Detalle Delete','../menudetalle/delete','LEXA'),(153,9,'Menu Detalle Update','../menudetalle/view','LEXA'),(154,9,'Menu Detalle View','../menudetalle/update','LEXA'),(155,9,'Menu Permiso Create','../menupermiso/create','ADMIN'),(156,9,'Menu Permiso Delete','../menupermiso/delete','ADMIN'),(157,9,'Menu Permiso Update','../menupermiso/update','ADMIN'),(158,9,'Menu Permiso View','../menupermiso/view','ADMIN'),(159,9,'Menu Update','../menu/update','LEXA'),(160,9,'Menu View','../menu/view','LEXA'),(161,9,'MenuUsuario Create','../menuusuario/create','ADMIN'),(162,9,'MenuUsuario Delete','../menuusuario/delete','ADMIN'),(163,9,'MenuUsuario Update','../menuusuario/update','ADMIN'),(164,9,'MenuUsuario View','../menuusuario/view','ADMIN'),(165,9,'MenuUsuarioAdmin Create','../menuusuarioadmin/create','LEXA'),(166,9,'MenuUsuarioAdmin Delete','../menuusuarioadmin/delete','LEXA'),(167,9,'MenuUsuarioAdmin Update','../menuusuarioadmin/update','LEXA'),(168,9,'MenuUsuarioAdmin View','../menuusuarioadmin/view','LEXA'),(169,9,'Movimiento Planilla Delete','../planillamoviemiento/delete','ADMIN'),(170,9,'Municipios Create','../municipios/create','LEXA'),(171,9,'Municipios Delete','../municipios/delete','LEXA'),(172,9,'Municipios Update','../municipios/update','LEXA'),(173,9,'Municipios View','../municipios/view','LEXA'),(174,9,'Parametros Planilla Delete','../parametrosplanilla/delete','ADMIN'),(175,9,'Parametros Planilla View','../parametrosplanilla/view','ADMIN'),(176,9,'Permisos Create','../permiso/create','ADMIN'),(177,9,'Permisos Delete','../permiso/delete','ADMIN'),(178,9,'Permisos Update','../permiso/update','ADMIN'),(179,9,'Permisos View','../permiso/view','ADMIN'),(180,9,'Propinas Create','../propinas/create','ADMIN'),(181,9,'Propinas Delete','../propinas/delete','ADMIN'),(182,9,'Propinas Update','../propinas/update','ADMIN'),(183,9,'Propinas View','../propinas/view','ADMIN'),(184,9,'Puesto Create','../puesto/create','LEXA'),(185,9,'Puesto Delete','../puesto/delete','LEXA'),(186,9,'Puesto Update','../puesto/update','LEXA'),(187,9,'Puesto View','../puesto/view','LEXA'),(188,9,'PuestoEmpresa Create','../puestoempresa/create','ADMIN'),(189,9,'PuestoEmpresa Delete','../puestoempresa/delete','ADMIN'),(190,9,'PuestoEmpresa Update','../puestoempresa/update','ADMIN'),(191,9,'PuestoEmpresa View','../puestoempresa/view','ADMIN'),(192,9,'TipoDocumento Create','../tipodocumento/create','LEXA'),(193,9,'TipoDocumento Delete','../tipodocumento/delete','LEXA'),(194,9,'TipoDocumento Update','../tipodocumento/update','LEXA'),(195,9,'TipoDocumento View','../tipodocumento/view','LEXA'),(196,9,'TipoEmpleado Create','../tipoempleado/create','LEXA'),(197,9,'TipoEmpleado Delete','../tipoempleado/delete','LEXA'),(198,9,'TipoEmpleado Update','../tipoempleado/update','LEXA'),(199,9,'TipoEmpleado View','../tipoempleado/view','LEXA'),(200,9,'Tramo AFP Create','../tramoafp/create','LEXA'),(201,9,'Tramo AFP Delete','../tramoafp/delete','LEXA'),(202,9,'Tramo AFP Update','../tramoafp/update','LEXA'),(203,9,'Tramo AFP View','../tramoafp/view','LEXA'),(204,9,'Tramo IPSFA Create','../tramoipsfa/create','LEXA'),(205,9,'Tramo IPSFA Delete','../tramoipsfa/delete','LEXA'),(206,9,'Tramo IPSFA Update','../tramoipsfa/update','LEXA'),(207,9,'Tramo IPSFA View','../tramoipsfa/view','LEXA'),(208,9,'Tramo ISR Create','../tramoisr/create','LEXA'),(209,9,'Tramo ISR Delete','../tramoisr/delete','LEXA'),(210,9,'Tramo ISR Update','../tramoisr/update','LEXA'),(211,9,'Tramo ISR View','../tramoisr/view','LEXA'),(212,9,'Tramo ISSS Create','../tramoisss/create','LEXA'),(213,9,'Tramo ISSS Update','../tramoisss/update','LEXA'),(214,9,'Tramo ISSS View','../tramoisss/view','LEXA'),(215,9,'Tramo ISSS View','../tramoisss/view','LEXA'),(216,9,'Usuario Create','../usuario/create','ADMIN'),(217,9,'Usuario Delete','../usuario/delete','ADMIN'),(218,9,'Usuario Update','../usuario/update','ADMIN'),(219,9,'Usuario View','../usuario/view','ADMIN'),(220,9,'Vacaciones Create','../indemnizacion/create','ADMIN'),(221,9,'Vacaciones Create','../vacaciones/create','ADMIN'),(222,9,'Vacaciones Delete','../indemnizacion/delete','ADMIN'),(223,9,'Vacaciones Delete','../vacaciones/delete','ADMIN'),(224,9,'Vacaciones Update','../indemnizacion/update','ADMIN'),(225,9,'Vacaciones Update','../vacaciones/update','ADMIN'),(226,9,'Vacaciones View','../indemnizacion/view','ADMIN'),(227,9,'Vacaciones View','../vacaciones/view','ADMIN'),(228,9,'Reportes SEPP Filter','../reportesepp/filter','ADMIN'),(229,9,'Reportes SEPP Report','../reportesepp/report','ADMIN');
/*!40000 ALTER TABLE `menudetalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menuusuario`
--

DROP TABLE IF EXISTS `menuusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menuusuario` (
  `IdMenuUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `IdMenuDetalle` int(11) NOT NULL,
  `MenuUsuarioActivo` varchar(1) DEFAULT NULL,
  `IdUsuario` int(11) NOT NULL,
  `IdMenu` int(11) DEFAULT NULL,
  `TipoPermiso` int(11) NOT NULL COMMENT 'Esto es lo que define si es un permiso para ingresar al menu o es permiso para ingresar a un crud 1 = menu 2 = crud',
  PRIMARY KEY (`IdMenuUsuario`),
  KEY `fk_menuusuario_usuario` (`IdUsuario`),
  KEY `fk_menuusuario_menudetalle_idx` (`IdMenuDetalle`),
  KEY `fk_menuusuario_menu_idx` (`IdMenu`),
  CONSTRAINT `fk_menuusuario_menu1` FOREIGN KEY (`IdMenu`) REFERENCES `menu` (`IdMenu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_menuusuario_menudetalle1` FOREIGN KEY (`IdMenuDetalle`) REFERENCES `menudetalle` (`IdMenuDetalle`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_menuusuario_usuario1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=362 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menuusuario`
--

LOCK TABLES `menuusuario` WRITE;
/*!40000 ALTER TABLE `menuusuario` DISABLE KEYS */;
INSERT INTO `menuusuario` VALUES (1,1,'1',1,1,1),(2,2,'1',1,1,1),(3,3,'1',1,1,1),(4,4,'1',1,1,1),(5,5,'1',1,2,1),(6,6,'1',1,2,1),(7,7,'1',1,2,1),(8,8,'1',1,2,1),(9,9,'1',1,2,1),(10,10,'1',1,2,1),(11,11,'1',1,2,1),(12,12,'1',1,2,1),(13,13,'1',1,2,1),(14,14,'1',1,2,1),(15,15,'1',1,2,1),(16,16,'1',1,2,1),(17,17,'1',1,2,1),(18,18,'1',1,2,1),(19,19,'1',1,2,1),(20,20,'1',1,2,1),(21,21,'1',1,3,1),(22,22,'1',1,3,1),(23,23,'1',1,3,1),(24,24,'1',1,3,1),(25,25,'1',1,3,1),(26,26,'1',1,4,1),(27,27,'1',1,4,1),(28,28,'1',1,4,1),(29,29,'1',1,4,1),(30,30,'1',1,5,1),(31,31,'1',1,5,1),(32,32,'1',1,5,1),(33,33,'1',1,5,1),(34,34,'1',1,6,1),(35,35,'1',1,6,1),(36,36,'1',1,6,1),(37,37,'1',1,6,1),(38,38,'1',1,6,1),(39,39,'1',1,6,1),(40,40,'1',1,6,1),(41,41,'1',1,6,1),(42,42,'1',1,6,1),(43,43,'1',1,6,1),(44,44,'1',1,6,1),(45,45,'1',1,6,1),(46,46,'1',1,7,1),(47,47,'1',1,7,1),(48,48,'1',1,7,1),(49,49,'1',1,7,1),(50,50,'1',1,7,1),(51,51,'1',1,7,1),(52,52,'1',1,7,1),(53,53,'1',1,7,1),(54,54,'1',1,7,1),(55,55,'1',1,8,1),(56,56,'1',1,9,2),(57,57,'1',1,9,2),(58,58,'1',1,9,2),(59,59,'1',1,9,2),(60,60,'1',1,9,2),(61,61,'1',1,9,2),(62,62,'1',1,9,2),(63,63,'1',1,9,2),(64,64,'1',1,9,2),(65,65,'1',1,9,2),(66,66,'1',1,9,2),(67,67,'1',1,9,2),(68,68,'1',1,9,2),(69,69,'1',1,9,2),(70,70,'1',1,9,2),(71,71,'1',1,9,2),(72,72,'1',1,9,2),(73,73,'1',1,9,2),(74,74,'1',1,9,2),(75,75,'1',1,9,2),(76,76,'1',1,9,2),(77,77,'1',1,9,2),(78,78,'1',1,9,2),(79,79,'1',1,9,2),(80,80,'1',1,9,2),(81,81,'1',1,9,2),(82,82,'1',1,9,2),(83,83,'1',1,9,2),(84,84,'1',1,9,2),(85,85,'1',1,9,2),(86,86,'1',1,9,2),(87,87,'1',1,9,2),(88,88,'1',1,9,2),(89,89,'1',1,9,2),(90,90,'1',1,9,2),(91,91,'1',1,9,2),(92,92,'1',1,9,2),(93,93,'1',1,9,2),(94,94,'1',1,9,2),(95,95,'1',1,9,2),(96,96,'1',1,9,2),(97,97,'1',1,9,2),(98,98,'1',1,9,2),(99,99,'1',1,9,2),(100,100,'1',1,9,2),(101,101,'1',1,9,2),(102,102,'1',1,9,2),(103,103,'1',1,9,2),(104,104,'1',1,9,2),(105,105,'1',1,9,2),(106,106,'1',1,9,2),(107,107,'1',1,9,2),(108,108,'1',1,9,2),(109,109,'1',1,9,2),(110,110,'1',1,9,2),(111,111,'1',1,9,2),(112,112,'1',1,9,2),(113,113,'1',1,9,2),(114,114,'1',1,9,2),(115,115,'1',1,9,2),(116,116,'1',1,9,2),(117,117,'1',1,9,2),(118,118,'1',1,9,2),(119,119,'1',1,9,2),(120,120,'1',1,9,2),(121,121,'1',1,9,2),(122,122,'1',1,9,2),(123,123,'1',1,9,2),(124,124,'1',1,9,2),(125,125,'1',1,9,2),(126,126,'1',1,9,2),(127,127,'1',1,9,2),(128,128,'1',1,9,2),(129,129,'1',1,9,2),(130,130,'1',1,9,2),(131,131,'1',1,9,2),(132,132,'1',1,9,2),(133,133,'1',1,9,2),(134,134,'1',1,9,2),(135,135,'1',1,9,2),(136,136,'1',1,9,2),(137,137,'1',1,9,2),(138,138,'1',1,9,2),(139,139,'1',1,9,2),(140,140,'1',1,9,2),(141,141,'1',1,9,2),(142,142,'1',1,9,2),(143,143,'1',1,9,2),(144,144,'1',1,9,2),(145,145,'1',1,9,2),(146,146,'1',1,9,2),(147,147,'1',1,9,2),(148,148,'1',1,9,2),(149,149,'1',1,9,2),(150,150,'1',1,9,2),(151,151,'1',1,9,2),(152,152,'1',1,9,2),(153,153,'1',1,9,2),(154,154,'1',1,9,2),(155,155,'1',1,9,2),(156,156,'1',1,9,2),(157,157,'1',1,9,2),(158,158,'1',1,9,2),(159,159,'1',1,9,2),(160,160,'1',1,9,2),(161,161,'1',1,9,2),(162,162,'1',1,9,2),(163,163,'1',1,9,2),(164,164,'1',1,9,2),(165,165,'1',1,9,2),(166,166,'1',1,9,2),(167,167,'1',1,9,2),(168,168,'1',1,9,2),(169,169,'1',1,9,2),(170,170,'1',1,9,2),(171,171,'1',1,9,2),(172,172,'1',1,9,2),(173,173,'1',1,9,2),(174,174,'1',1,9,2),(175,175,'1',1,9,2),(176,176,'1',1,9,2),(177,177,'1',1,9,2),(178,178,'1',1,9,2),(179,179,'1',1,9,2),(180,180,'1',1,9,2),(181,181,'1',1,9,2),(182,182,'1',1,9,2),(183,183,'1',1,9,2),(184,184,'1',1,9,2),(185,185,'1',1,9,2),(186,186,'1',1,9,2),(187,187,'1',1,9,2),(188,188,'1',1,9,2),(189,189,'1',1,9,2),(190,190,'1',1,9,2),(191,191,'1',1,9,2),(192,192,'1',1,9,2),(193,193,'1',1,9,2),(194,194,'1',1,9,2),(195,195,'1',1,9,2),(196,196,'1',1,9,2),(197,197,'1',1,9,2),(198,198,'1',1,9,2),(199,199,'1',1,9,2),(200,200,'1',1,9,2),(201,201,'1',1,9,2),(202,202,'1',1,9,2),(203,203,'1',1,9,2),(204,204,'1',1,9,2),(205,205,'1',1,9,2),(206,206,'1',1,9,2),(207,207,'1',1,9,2),(208,208,'1',1,9,2),(209,209,'1',1,9,2),(210,210,'1',1,9,2),(211,211,'1',1,9,2),(212,212,'1',1,9,2),(213,213,'1',1,9,2),(214,214,'1',1,9,2),(215,215,'1',1,9,2),(216,216,'1',1,9,2),(217,217,'1',1,9,2),(218,218,'1',1,9,2),(219,219,'1',1,9,2),(220,220,'1',1,9,2),(221,221,'1',1,9,2),(222,222,'1',1,9,2),(223,223,'1',1,9,2),(224,224,'1',1,9,2),(225,225,'1',1,9,2),(226,226,'1',1,9,2),(227,227,'1',1,9,2),(228,21,'1',2,3,1),(229,22,'1',2,3,1),(230,23,'1',2,3,1),(231,24,'1',2,3,1),(232,25,'1',2,3,1),(233,26,'1',2,4,1),(234,27,'1',2,4,1),(235,28,'1',2,4,1),(236,29,'1',2,4,1),(237,30,'1',2,5,1),(238,31,'1',2,5,1),(239,32,'1',2,5,1),(240,33,'1',2,5,1),(241,34,'1',2,6,1),(242,35,'1',2,6,1),(243,36,'1',2,6,1),(244,37,'1',2,6,1),(245,38,'1',2,6,1),(246,39,'1',2,6,1),(247,40,'1',2,6,1),(248,41,'1',2,6,1),(249,42,'1',2,6,1),(250,43,'1',2,6,1),(251,44,'1',2,6,1),(252,45,'1',2,6,1),(253,46,'1',2,7,1),(254,47,'1',2,7,1),(255,48,'1',2,7,1),(256,49,'1',2,7,1),(257,50,'1',2,7,1),(258,51,'1',2,7,1),(259,52,'1',2,7,1),(260,53,'1',2,7,1),(261,54,'1',2,7,1),(262,55,'1',2,8,1),(263,56,'1',2,9,2),(264,57,'1',2,9,2),(265,58,'1',2,9,2),(266,59,'1',2,9,2),(267,60,'1',2,9,2),(268,61,'1',2,9,2),(269,62,'1',2,9,2),(270,63,'1',2,9,2),(271,64,'1',2,9,2),(272,65,'1',2,9,2),(273,66,'1',2,9,2),(274,67,'1',2,9,2),(275,68,'1',2,9,2),(276,69,'1',2,9,2),(277,70,'1',2,9,2),(278,75,'1',2,9,2),(279,76,'1',2,9,2),(280,77,'1',2,9,2),(281,78,'1',2,9,2),(282,79,'1',2,9,2),(283,80,'1',2,9,2),(284,81,'1',2,9,2),(285,82,'1',2,9,2),(286,83,'1',2,9,2),(287,96,'1',2,9,2),(288,97,'1',2,9,2),(289,98,'1',2,9,2),(290,99,'1',2,9,2),(291,100,'1',2,9,2),(292,104,'1',2,9,2),(293,105,'1',2,9,2),(294,106,'1',2,9,2),(295,109,'1',2,9,2),(296,110,'1',2,9,2),(297,111,'1',2,9,2),(298,112,'1',2,9,2),(299,115,'1',2,9,2),(300,116,'1',2,9,2),(301,117,'1',2,9,2),(302,118,'1',2,9,2),(303,119,'1',2,9,2),(304,120,'1',2,9,2),(305,121,'1',2,9,2),(306,122,'1',2,9,2),(307,127,'1',2,9,2),(308,128,'1',2,9,2),(309,129,'1',2,9,2),(310,130,'1',2,9,2),(311,131,'1',2,9,2),(312,132,'1',2,9,2),(313,133,'1',2,9,2),(314,134,'1',2,9,2),(315,135,'1',2,9,2),(316,136,'1',2,9,2),(317,137,'1',2,9,2),(318,138,'1',2,9,2),(319,139,'1',2,9,2),(320,140,'1',2,9,2),(321,141,'1',2,9,2),(322,142,'1',2,9,2),(323,143,'1',2,9,2),(324,144,'1',2,9,2),(325,155,'1',2,9,2),(326,156,'1',2,9,2),(327,157,'1',2,9,2),(328,158,'1',2,9,2),(329,161,'1',2,9,2),(330,162,'1',2,9,2),(331,163,'1',2,9,2),(332,164,'1',2,9,2),(333,169,'1',2,9,2),(334,174,'1',2,9,2),(335,175,'1',2,9,2),(336,176,'1',2,9,2),(337,177,'1',2,9,2),(338,178,'1',2,9,2),(339,179,'1',2,9,2),(340,180,'1',2,9,2),(341,181,'1',2,9,2),(342,182,'1',2,9,2),(343,183,'1',2,9,2),(344,188,'1',2,9,2),(345,189,'1',2,9,2),(346,190,'1',2,9,2),(347,191,'1',2,9,2),(348,216,'1',2,9,2),(349,217,'1',2,9,2),(350,218,'1',2,9,2),(351,219,'1',2,9,2),(352,220,'1',2,9,2),(353,221,'1',2,9,2),(354,222,'1',2,9,2),(355,223,'1',2,9,2),(356,224,'1',2,9,2),(357,225,'1',2,9,2),(358,226,'1',2,9,2),(359,227,'1',2,9,2),(360,228,'1',1,9,2),(361,229,'1',1,9,2);
/*!40000 ALTER TABLE `menuusuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `municipios`
--

DROP TABLE IF EXISTS `municipios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `municipios` (
  `IdMunicipios` varchar(45) NOT NULL,
  `DescripcionMunicipios` varchar(45) NOT NULL,
  `IdPadre` varchar(45) DEFAULT NULL,
  `Nivel` int(11) NOT NULL,
  `Jerarquia` varchar(45) NOT NULL,
  `IdDepartamentos` varchar(45) NOT NULL,
  PRIMARY KEY (`IdMunicipios`),
  KEY `fk_municipios_departamentos_idx` (`IdDepartamentos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipios`
--

LOCK TABLES `municipios` WRITE;
/*!40000 ALTER TABLE `municipios` DISABLE KEYS */;
INSERT INTO `municipios` VALUES ('0','Geografia No Definida','NULL',0,'.0.					',''),('01','AHUACHAPAN','3',1,'.3.01.					',''),('0101','AHUACHAPAN','01',2,'.3.01.0101.					','01'),('0102','APANECA','01',2,'.3.01.0102.					','01'),('0103','ATIQUIZAYA','01',2,'.3.01.0103.					','01'),('0104','CONCEPCION DE ATACO','01',2,'.3.01.0104.					','01'),('0105','EL REFUGIO','01',2,'.3.01.0105.					','01'),('0106','GUAYMANGO','01',2,'.3.01.0106.					','01'),('0107','JUJUTLA','01',2,'.3.01.0107.					','01'),('0108','SAN FRANCISCO MENENDEZ','01',2,'.3.01.0108.					','01'),('0109','SAN LORENZO','01',2,'.3.01.0109.					','01'),('0110','SAN PEDRO PUXTLA','01',2,'.3.01.0110.					','01'),('0111','TACUBA','01',2,'.3.01.0111.					','01'),('0112','TURIN','01',2,'.3.01.0112.					','01'),('02','SANTA ANA','3',1,'.3.02.					',''),('0201','SANTA ANA','02',2,'.3.02.0201.					','02'),('0202','CANDELARIA DE LA FRONTERA','02',2,'.3.02.0202.					','02'),('0203','COATEPEQUE','02',2,'.3.02.0203.					','02'),('0204','CHALCHUAPA','02',2,'.3.02.0204.					','02'),('0205','EL CONGO','02',2,'.3.02.0205.					','02'),('0206','EL PORVENIR','02',2,'.3.02.0206.					','02'),('0207','MASAHUAT','02',2,'.3.02.0207.					','02'),('0208','METAPAN','02',2,'.3.02.0208.					','02'),('0209','SAN ANTONIO PAJONAL','02',2,'.3.02.0209.					','02'),('0210','SAN SEBASTIAN SALITRILLO','02',2,'.3.02.0210.					','02'),('0211','SANTA ROSA GUACHIPILIN','02',2,'.3.02.0211.					','02'),('0212','SANTIAGO DE LA FRONTERA','02',2,'.3.02.0212.					','02'),('0213','TEXISTEPEQUE','02',2,'.3.02.0213.					','02'),('03','SONSONATE','3',1,'.3.03.					',''),('0301','SONSONATE','03',2,'.3.03.0301.					','03'),('0302','ACAJUTLA','03',2,'.3.03.0302.					','03'),('0303','ARMENIA','03',2,'.3.03.0303.					','03'),('0304','CALUCO','03',2,'.3.03.0304.					','03'),('0305','CUISNAHUAT','03',2,'.3.03.0305.					','03'),('0306','IZALCO','03',2,'.3.03.0306.					','03'),('0307','JUAYUA','03',2,'.3.03.0307.					','03'),('0308','NAHUIZALCO','03',2,'.3.03.0308.					','03'),('0309','NAHUILINGO','03',2,'.3.03.0309.					','03'),('0310','SALCOATITAN','03',2,'.3.03.0310.					','03'),('0311','SAN ANTONIO DEL MONTE','03',2,'.3.03.0311.					','03'),('0312','SAN JULIAN','03',2,'.3.03.0312.					','03'),('0313','SANTA CATARINA MASAHUAT','03',2,'.3.03.0313.					','03'),('0314','SANTA ISABEL ISHUATAN','03',2,'.3.03.0314.					','03'),('0315','SANTO DOMINGO DE GUZMAN','03',2,'.3.03.0315.					','03'),('0316','SONZACATE','03',2,'.3.03.0316.					','03'),('04','CHALATENANGO','1',1,'.1.04.					',''),('0401','CHALATENANGO','04',2,'.1.04.0401.					','04'),('0402','AGUA CALIENTE','04',2,'.1.04.0402.					','04'),('0403','ARCATAO','04',2,'.1.04.0403.					','04'),('0404','AZACUALPA','04',2,'.1.04.0404.					','04'),('0405','CANCASQUE','04',2,'.1.04.0405.					','04'),('0406','CITALA','04',2,'.1.04.0406.					','04'),('0407','COMALAPA','04',2,'.1.04.0407.					','04'),('0408','CONCEPCION QUEZALTEPEQUE','04',2,'.1.04.0408.					','04'),('0409','DULCE NOMBRE DE MARIA','04',2,'.1.04.0409.					','04'),('0410','EL CARRIZAL','04',2,'.1.04.0410.					','04'),('0411','EL PARAISO','04',2,'.1.04.0411.					','04'),('0412','LA LAGUNA','04',2,'.1.04.0412.					','04'),('0413','LA PALMA','04',2,'.1.04.0413.					','04'),('0414','LA REINA','04',2,'.1.04.0414.					','04'),('0415','LAS FLORES','04',2,'.1.04.0415.					','04'),('0416','LAS VUELTAS','04',2,'.1.04.0416.					','04'),('0417','NOMBRE DE JESUS','04',2,'.1.04.0417.					','04'),('0418','NUEVA CONCEPCION','04',2,'.1.04.0418.					','04'),('0419','NUEVA TRINIDAD','04',2,'.1.04.0419.					','04'),('0420','OJOS DE AGUA','04',2,'.1.04.0420.					','04'),('0421','POTONICO','04',2,'.1.04.0421.					','04'),('0422','SAN ANTONIO DE LA CRUZ','04',2,'.1.04.0422.					','04'),('0423','SAN ANTONIO DE LOS RANCHOS','04',2,'.1.04.0423.					','04'),('0424','SAN FERNANDO','04',2,'.1.04.0424.					','04'),('0425','SAN FRANCISCO LEMPA','04',2,'.1.04.0425.					','04'),('0426','SAN FRANCISCO MORAZAN','04',2,'.1.04.0426.					','04'),('0427','SAN IGNACIO','04',2,'.1.04.0427.					','04'),('0428','SAN ISIDRO LABRADOR','04',2,'.1.04.0428.					','04'),('0429','SAN LUIS DEL CARMEN','04',2,'.1.04.0429.					','04'),('0430','SAN MIGUEL DE MERCEDES','04',2,'.1.04.0430.					','04'),('0431','SAN RAFAEL','04',2,'.1.04.0431.					','04'),('0432','SANTA RITA','04',2,'.1.04.0432.					','04'),('0433','TEJUTLA','04',2,'.1.04.0433.					','04'),('05','LA LIBERTAD','1',1,'.1.05.					',''),('0501','SANTA TECLA','05',2,'.1.05.0501.					','05'),('0502','ANTIGUO CUSCATLAN','05',2,'.1.05.0502.					','05'),('0503','CIUDAD ARCE','05',2,'.1.05.0503.					','05'),('0504','COLON','05',2,'.1.05.0504.					','05'),('0505','COMASAGUA','05',2,'.1.05.0505.					','05'),('0506','CHILTIUPAN','05',2,'.1.05.0506.					','05'),('0507','HUIZUCAR','05',2,'.1.05.0507.					','05'),('0508','JAYAQUE','05',2,'.1.05.0508.					','05'),('0509','JICALAPA','05',2,'.1.05.0509.					','05'),('0510','LA LIBERTAD','05',2,'.1.05.0510.					','05'),('0511','NUEVO CUSCATLAN','05',2,'.1.05.0511.					','05'),('0512','SAN JUAN OPICO','05',2,'.1.05.0512.					','05'),('0513','QUEZALTEPEQUE','05',2,'.1.05.0513.					','05'),('0514','SACACOYO','05',2,'.1.05.0514.					','05'),('0515','SAN JOSE VILLANUEVA','05',2,'.1.05.0515.					','05'),('0516','SAN MATIAS','05',2,'.1.05.0516.					','05'),('0517','SAN PABLO TACACHICO','05',2,'.1.05.0517.					','05'),('0518','TALNIQUE','05',2,'.1.05.0518.					','05'),('0519','TAMANIQUE','05',2,'.1.05.0519.					','05'),('0520','TEOTEPEQUE','05',2,'.1.05.0520.					','05'),('0521','TEPECOYO','05',2,'.1.05.0521.					','05'),('0522','ZARAGOZA','05',2,'.1.05.0522.					','05'),('06','SAN SALVADOR','1',1,'.1.06.					',''),('0601','SAN SALVADOR','06',2,'.1.06.0601.					','06'),('0602','AGUILARES','06',2,'.1.06.0602.					','06'),('0603','APOPA','06',2,'.1.06.0603.					','06'),('0604','AYUTUXTEPEQUE','06',2,'.1.06.0604.					','06'),('0605','CUSCATANCINGO','06',2,'.1.06.0605.					','06'),('0606','CIUDAD DELGADO','06',2,'.1.06.0606.					','06'),('0607','EL PAISNAL','06',2,'.1.06.0607.					','06'),('0608','GUAZAPA','06',2,'.1.06.0608.					','06'),('0609','ILOPANGO','06',2,'.1.06.0609.					','06'),('0610','MEJICANOS','06',2,'.1.06.0610.					','06'),('0611','NEJAPA','06',2,'.1.06.0611.					','06'),('0612','PANCHIMALCO','06',2,'.1.06.0612.					','06'),('0613','ROSARIO DE MORA','06',2,'.1.06.0613.					','06'),('0614','SAN MARCOS','06',2,'.1.06.0614.					','06'),('0615','SAN MARTIN','06',2,'.1.06.0615.					','06'),('0616','SANTIAGO TEXACUANGOS','06',2,'.1.06.0616.					','06'),('0617','SANTO TOMAS','06',2,'.1.06.0617.					','06'),('0618','SOYAPANGO','06',2,'.1.06.0618.					','06'),('0619','TONACATEPEQUE','06',2,'.1.06.0619.					','06'),('07','CUSCATLAN','4',1,'.4.07.					',''),('0701','COJUTEPEQUE','07',2,'.4.07.0701.					','07'),('0702','CANDELARIA','07',2,'.4.07.0702.					','07'),('0703','EL CARMEN','07',2,'.4.07.0703.					','07'),('0704','EL ROSARIO','07',2,'.4.07.0704.					','07'),('0705','MONTE SAN JUAN','07',2,'.4.07.0705.					','07'),('0706','ORATORIO DE CONCEPCION','07',2,'.4.07.0706.					','07'),('0707','SAN BARTOLOME PERULAPIA','07',2,'.4.07.0707.					','07'),('0708','SAN CRISTOBAL','07',2,'.4.07.0708.					','07'),('0709','SAN JOSE GUAYABAL','07',2,'.4.07.0709.					','07'),('0710','SAN PEDRO PERULAPAN','07',2,'.4.07.0710.					','07'),('0711','SAN RAFAEL CEDROS','07',2,'.4.07.0711.					','07'),('0712','SAN RAMON','07',2,'.4.07.0712.					','07'),('0713','SANTA CRUZ ANALQUITO','07',2,'.4.07.0713.					','07'),('0714','SANTA CRUZ MICHAPA','07',2,'.4.07.0714.					','07'),('0715','SUCHITOTO','07',2,'.4.07.0715.					','07'),('0716','TENANCINGO','07',2,'.4.07.0716.					','07'),('08','LA PAZ','4',1,'.4.08.					',''),('0801','ZACATECOLUCA','08',2,'.4.08.0801.					','08'),('0802','CUYULTITAN','08',2,'.4.08.0802.					','08'),('0803','EL ROSARIO','08',2,'.4.08.0803.					','08'),('0804','JERUSALEN','08',2,'.4.08.0804.					','08'),('0805','MERCEDES LA CEIBA','08',2,'.4.08.0805.					','08'),('0806','OLOCUILTA','08',2,'.4.08.0806.					','08'),('0807','PARAISO DE OSORIO','08',2,'.4.08.0807.					','08'),('0808','SAN ANTONIO MASAHUAT','08',2,'.4.08.0808.					','08'),('0809','SAN EMIGDIO','08',2,'.4.08.0809.					','08'),('0810','SAN FRANCISCO CHINAMECA','08',2,'.4.08.0810.					','08'),('0811','SAN JUAN NONUALCO','08',2,'.4.08.0811.					','08'),('0812','SAN JUAN TALPA','08',2,'.4.08.0812.					','08'),('0813','SAN JUAN TEPEZONTES','08',2,'.4.08.0813.					','08'),('0814','SAN LUIS TALPA','08',2,'.4.08.0814.					','08'),('0815','SAN LUIS LA HERRADURA','08',2,'.4.08.0815.					','08'),('0816','SAN MIGUEL TEPEZONTES','08',2,'.4.08.0816.					','08'),('0817','SAN PEDRO MASAHUAT','08',2,'.4.08.0817.					','08'),('0818','SAN PEDRO NONUALCO','08',2,'.4.08.0818.					','08'),('0819','SAN RAFAEL OBRAJUELO','08',2,'.4.08.0819.					','08'),('0820','SANTA MARIA OSTUMA','08',2,'.4.08.0820.					','08'),('0821','SANTIAGO NONUALCO','08',2,'.4.08.0821.					','08'),('0822','TAPALHUACA','08',2,'.4.08.0822.					','08'),('09','CABANAS','4',1,'.4.09.					',''),('0901','SENSUNTEPEQUE','09',2,'.4.09.0901.					','09'),('0902','CINQUERA','09',2,'.4.09.0902.					','09'),('0903','DOLORES','09',2,'.4.09.0903.					','09'),('0904','GUACOTECTI','09',2,'.4.09.0904.					','09'),('0905','ILOBASCO','09',2,'.4.09.0905.					','09'),('0906','JUTIAPA','09',2,'.4.09.0906.					','09'),('0907','SAN ISIDRO','09',2,'.4.09.0907.					','09'),('0908','TEJUTEPEQUE','09',2,'.4.09.0908.					','09'),('0909','VICTORIA','09',2,'.4.09.0909.					','09'),('1','ZONA CENTRAL','NULL',0,'.1.					',''),('10','SAN VICENTE','4',1,'.4.10.					',''),('1001','SAN VICENTE','10',2,'.4.10.1001.					','10'),('100101','CALDERAS','1001',3,'.4.10.1001.100101.					',''),('100102','EL GUAYABO','1001',3,'.4.10.1001.100102.					',''),('100103','LAS MINAS','1001',3,'.4.10.1001.100103.					',''),('100104','SAN FELIPE','1001',3,'.4.10.1001.100104.					',''),('100105','SAN JACINTO','1001',3,'.4.10.1001.100105.					',''),('100106','SAN JUAN DE MERINO','1001',3,'.4.10.1001.100106.					',''),('100107','SAN NICOLAS','1001',3,'.4.10.1001.100107.					',''),('100108','SAN PEDRO','1001',3,'.4.10.1001.100108.					',''),('100109','CUTUMAYO','1001',3,'.4.10.1001.100109.					',''),('100110','SAN JOSE ALMENDROS','1001',3,'.4.10.1001.100110.					',''),('1002','APASTEPEQUE','10',2,'.4.10.1002.					','10'),('100201','GUADALUPE','1002',3,'.4.10.1002.100201.					',''),('100202','JOYA DE MUNGUIA','1002',3,'.4.10.1002.100202.					',''),('100203','SAN JOSE CARBONERA','1002',3,'.4.10.1002.100203.					',''),('100204','SAN FRANCISCO AGUA AGRIA','1002',3,'.4.10.1002.100204.					',''),('100205','SAN ANTONIO LOS RANCHOS','1002',3,'.4.10.1002.100205.					',''),('100206','SAN BENITO PIEDRA GORDA','1002',3,'.4.10.1002.100206.					',''),('100207','SAN EMIGDIO EL TABLON','1002',3,'.4.10.1002.100207.					',''),('1003','GUADALUPE','10',2,'.4.10.1003.					','10'),('100301','CANDELARIA','1003',3,'.4.10.1003.100301.					',''),('100302','SAN JOSE CERRO GRANDE','1003',3,'.4.10.1003.100302.					',''),('1004','SAN CAYETANO ISTEPEQUE','10',2,'.4.10.1004.					','10'),('100401','AGUA HELADA','1004',3,'.4.10.1004.100401.					',''),('100402','EL ROSARIO','1004',3,'.4.10.1004.100402.					',''),('100403','SAN JERONIMO','1004',3,'.4.10.1004.100403.					',''),('100404','SANTA ROSA','1004',3,'.4.10.1004.100404.					',''),('100405','EL TORTUGUERO','1004',3,'.4.10.1004.100405.					',''),('100406','SAN JUAN DE MERINOS','1004',3,'.4.10.1004.100406.					',''),('1005','SAN ESTEBAN CATARINA','10',2,'.4.10.1005.					','10'),('100501','EL REFUGIO','1005',3,'.4.10.1005.100501.					',''),('100502','LOS RODRIGUEZ','1005',3,'.4.10.1005.100502.					',''),('100503','TALPETATES','1005',3,'.4.10.1005.100503.					',''),('100504','SAN ANTONIO IZCANALEZ','1005',3,'.4.10.1005.100504.					',''),('1006','SAN ILDEFONSO','10',2,'.4.10.1006.					','10'),('100601','AMATITAN ABAJO','1006',3,'.4.10.1006.100601.					',''),('100602','AMATITAN ARRIBA','1006',3,'.4.10.1006.100602.					',''),('100603','SAN ESTEBAN','1006',3,'.4.10.1006.100603.					',''),('100604','SANTA CATARINA','1006',3,'.4.10.1006.100604.					',''),('100605','SAN ILDEFONSO','1006',3,'.4.10.1006.100605.					',''),('100606','SAN JACINTO LA BURRERA','1006',3,'.4.10.1006.100606.					',''),('1007','SAN LORENZO','10',2,'.4.10.1007.					','10'),('100701','CANDELARIA LEMPA','1007',3,'.4.10.1007.100701.					',''),('100702','GUACHIPILIN','1007',3,'.4.10.1007.100702.					',''),('100703','LAJAS Y CANOAS','1007',3,'.4.10.1007.100703.					',''),('100704','SAN FRANCISCO','1007',3,'.4.10.1007.100704.					',''),('100705','SAN LORENZO','1007',3,'.4.10.1007.100705.					',''),('100706','SAN PABLO CANALES','1007',3,'.4.10.1007.100706.					',''),('1008','SAN SEBASTIAN','10',2,'.4.10.1008.					','10'),('100801','LA CRUZ','1008',3,'.4.10.1008.100801.					',''),('100802','LAS ANIMAS','1008',3,'.4.10.1008.100802.					',''),('100803','SAN FRANCISCO','1008',3,'.4.10.1008.100803.					',''),('100804','SANTA LUCIA','1008',3,'.4.10.1008.100804.					',''),('1009','SANTA CLARA','10',2,'.4.10.1009.					','10'),('100901','EL PARAISO','1009',3,'.4.10.1009.100901.					',''),('100902','EL PORVENIR AGUACAYO','1009',3,'.4.10.1009.100902.					',''),('100903','LA ESPERANZA','1009',3,'.4.10.1009.100903.					',''),('100904','LA LABOR','1009',3,'.4.10.1009.100904.					',''),('100905','LAS ROSAS','1009',3,'.4.10.1009.100905.					',''),('100906','LOS LAURELES','1009',3,'.4.10.1009.100906.					',''),('100907','SAN FRANCISCO','1009',3,'.4.10.1009.100907.					',''),('100908','SANTA ELENA','1009',3,'.4.10.1009.100908.					',''),('100909','SANTA TERESA','1009',3,'.4.10.1009.100909.					',''),('1010','SANTO DOMINGO','10',2,'.4.10.1010.					','10'),('101001','CANTON LAS FLORES','1010',3,'.4.10.1010.101001.					',''),('101002','CHUCUYO','1010',3,'.4.10.1010.101002.					',''),('101003','DOS QUEBRADAS','1010',3,'.4.10.1010.101003.					',''),('101004','EL MARQUEZADO','1010',3,'.4.10.1010.101004.					',''),('101005','EL REBELDE','1010',3,'.4.10.1010.101005.					',''),('101006','LA JOYA','1010',3,'.4.10.1010.101006.					',''),('101007','LA SOLEDAD','1010',3,'.4.10.1010.101007.					',''),('101008','LOS LAURELES','1010',3,'.4.10.1010.101008.					',''),('101009','LOS POZOS','1010',3,'.4.10.1010.101009.					',''),('101010','OBRAJUELO LEMPA','1010',3,'.4.10.1010.101010.					',''),('101011','PARRAS LEMPA','1010',3,'.4.10.1010.101011.					',''),('101012','SAN ANTONIO CAMINOS','1010',3,'.4.10.1010.101012.					',''),('101013','SAN DIEGO','1010',3,'.4.10.1010.101013.					',''),('101014','SAN JACINTO','1010',3,'.4.10.1010.101014.					',''),('101015','SAN JOSE RIO FRIO','1010',3,'.4.10.1010.101015.					',''),('101016','SANTA GERTRUDIS','1010',3,'.4.10.1010.101016.					',''),('101017','LLANOS DE ACHICHILCO','1010',3,'.4.10.1010.101017.					',''),('101018','SAN JUAN BUENAVISTA','1010',3,'.4.10.1010.101018.					',''),('101019','SAN ANTONIO ACHICHILCO','1010',3,'.4.10.1010.101019.					',''),('101020','SAN ANTONIO TRA','1010',3,'.4.10.1010.101020.					',''),('101021','SAN BARTOLO ICHANMICO','1010',3,'.4.10.1010.101021.					',''),('101022','SAN FRANCISCO CHAMOCO','1010',3,'.4.10.1010.101022.					',''),('1011','TECOLUCA','10',2,'.4.10.1011.					','10'),('101101','EL ARCO','1011',3,'.4.10.1011.101101.					',''),('101102','EL CAMPANARIO','1011',3,'.4.10.1011.101102.					',''),('101103','EL CARAO','1011',3,'.4.10.1011.101103.					',''),('101104','EL COYOLITO','1011',3,'.4.10.1011.101104.					',''),('101105','EL PACUN','1011',3,'.4.10.1011.101105.					',''),('101106','EL PALOMAR','1011',3,'.4.10.1011.101106.					',''),('101107','EL PERICAL','1011',3,'.4.10.1011.101107.					',''),('101108','EL PUENTE','1011',3,'.4.10.1011.101108.					',''),('101109','EL SOCORRO','1011',3,'.4.10.1011.101109.					',''),('101110','LA ESPERANZA','1011',3,'.4.10.1011.101110.					',''),('101111','LAS ANONAS','1011',3,'.4.10.1011.101111.					',''),('101112','LAS MESAS','1011',3,'.4.10.1011.101112.					',''),('101113','SAN JOSE LLANO GRANDE','1011',3,'.4.10.1011.101113.					',''),('101114','SAN ANTONIO ACH','1011',3,'.4.10.1011.101114.					',''),('101115','SAN BENITO','1011',3,'.4.10.1011.101115.					',''),('101116','SAN CARLOS','1011',3,'.4.10.1011.101116.					',''),('101117','SAN FRANCISCO ANGULO','1011',3,'.4.10.1011.101117.					',''),('101118','SAN FERNANDO','1011',3,'.4.10.1011.101118.					',''),('101119','SAN NICOLAS LEMPA','1011',3,'.4.10.1011.101119.					',''),('101120','SAN RAMON GRIFAL','1011',3,'.4.10.1011.101120.					',''),('101121','SANTA BARBARA','1011',3,'.4.10.1011.101121.					',''),('101122','SANTA CRUZ','1011',3,'.4.10.1011.101122.					',''),('101123','LAS PAMPAS','1011',3,'.4.10.1011.101123.					',''),('101124','SANTA CRUZ PORRILLO','1011',3,'.4.10.1011.101124.					',''),('101125','EL PORTILLO','1011',3,'.4.10.1011.101125.					',''),('101126','SAN ANDRES ACHI','1011',3,'.4.10.1011.101126.					',''),('101127','BARRIO NUEVO','1011',3,'.4.10.1011.101127.					',''),('101128','SANTA MARTA','1011',3,'.4.10.1011.101128.					',''),('1012','TEPETITAN','10',2,'.4.10.1012.					','10'),('101201','LA VIRGEN','1012',3,'.4.10.1012.101201.					',''),('101202','LOMA ALTA','1012',3,'.4.10.1012.101202.					',''),('101203','CONCEPCION DE CANAS','1012',3,'.4.10.1012.101203.					',''),('1013','VERAPAZ','10',2,'.4.10.1013.					','10'),('101301','EL CARMEN','1013',3,'.4.10.1013.101301.					',''),('101302','MOLINEROS','1013',3,'.4.10.1013.101302.					',''),('101303','SAN ANTONIO JIBOA','1013',3,'.4.10.1013.101303.					',''),('101304','SAN ISIDRO','1013',3,'.4.10.1013.101304.					',''),('101305','SAN JERONIMO LIMON','1013',3,'.4.10.1013.101305.					',''),('101306','SAN JOSE BORJA','1013',3,'.4.10.1013.101306.					',''),('101307','SAN JUAN BUENAVISTA','1013',3,'.4.10.1013.101307.					',''),('101308','SAN PEDRO AGUA CALIENTE','1013',3,'.4.10.1013.101308.					',''),('11','USULUTAN','2',1,'.2.11.					',''),('1101','USULUTAN','11',2,'.2.11.1101.					','11'),('110101','ZAPOTILLO','1101',3,'.2.11.1101.110101.					',''),('110102','APASTEPEQUE','1101',3,'.2.11.1101.110102.					',''),('110103','LAS CASITAS','1101',3,'.2.11.1101.110103.					',''),('110104','LA PENA','1101',3,'.2.11.1101.110104.					',''),('110105','MONTANITA','1101',3,'.2.11.1101.110105.					',''),('110106','QUEBRACHO','1101',3,'.2.11.1101.110106.					',''),('110107','SAN JUAN','1101',3,'.2.11.1101.110107.					',''),('110108','YOMO','1101',3,'.2.11.1101.110108.					',''),('1102','ALEGRIA','11',2,'.2.11.1102.					','11'),('110201','COLON','1102',3,'.2.11.1102.110201.					',''),('110202','CONCEPCION','1102',3,'.2.11.1102.110202.					',''),('110203','EL COROZAL','1102',3,'.2.11.1102.110203.					',''),('110204','EL TABLON','1102',3,'.2.11.1102.110204.					',''),('110205','LA UNION','1102',3,'.2.11.1102.110205.					',''),('110206','LAS DELICIAS','1102',3,'.2.11.1102.110206.					',''),('110207','LAS PILETAS','1102',3,'.2.11.1102.110207.					',''),('110208','LOS TALPETATES','1102',3,'.2.11.1102.110208.					',''),('110209','SAN FELIPE','1102',3,'.2.11.1102.110209.					',''),('110210','SAN FRANCISCO','1102',3,'.2.11.1102.110210.					',''),('110211','SAN ISIDRO','1102',3,'.2.11.1102.110211.					',''),('110212','SAN JOSE','1102',3,'.2.11.1102.110212.					',''),('110213','SAN JUAN LOMA ALTA','1102',3,'.2.11.1102.110213.					',''),('110214','SAN LORENZO','1102',3,'.2.11.1102.110214.					',''),('110215','SANTA CRUZ','1102',3,'.2.11.1102.110215.					',''),('110216','VIRGINIA','1102',3,'.2.11.1102.110216.					',''),('1103','BERLIN','11',2,'.2.11.1103.					','11'),('110301','EL POZON','1103',3,'.2.11.1103.110301.					',''),('1104','CALIFORNIA','11',2,'.2.11.1104.					','11'),('110401','EL PARAISAL','1104',3,'.2.11.1104.110401.					',''),('110402','HACIENDA NUEVA','1104',3,'.2.11.1104.110402.					',''),('110403','LA ANCHILA','1104',3,'.2.11.1104.110403.					',''),('110404','LA DANTA','1104',3,'.2.11.1104.110404.					',''),('110405','SAN ANTONIO','1104',3,'.2.11.1104.110405.					',''),('110406','SAN FELIPE','1104',3,'.2.11.1104.110406.					',''),('110407','SAN ILDEFONSO','1104',3,'.2.11.1104.110407.					',''),('110408','EL CANAL','1104',3,'.2.11.1104.110408.					',''),('110409','EL PORVENIR','1104',3,'.2.11.1104.110409.					',''),('1105','CONCEPCION BATRES','11',2,'.2.11.1105.					','11'),('110501','EL PALON','1105',3,'.2.11.1105.110501.					',''),('110502','EL JICARITO','1105',3,'.2.11.1105.110502.					',''),('110503','SAN ANTONIO','1105',3,'.2.11.1105.110503.					',''),('110504','LA PALMERA','1105',3,'.2.11.1105.110504.					',''),('110505','LOS NOVILLOS','1105',3,'.2.11.1105.110505.					',''),('1106','EL TRIUNFO','11',2,'.2.11.1106.					','11'),('110601','ANALCO','1106',3,'.2.11.1106.110601.					',''),('110602','LA CEIBA','1106',3,'.2.11.1106.110602.					',''),('110603','LOS ENCUENTROS','1106',3,'.2.11.1106.110603.					',''),('110604','MACULIS','1106',3,'.2.11.1106.110604.					',''),('1107','EREGUAYQUIN','11',2,'.2.11.1107.					','11'),('110701','CONDADILLO','1107',3,'.2.11.1107.110701.					',''),('110702','ESCARBADERO','1107',3,'.2.11.1107.110702.					',''),('110703','LA CRUZ','1107',3,'.2.11.1107.110703.					',''),('110704','PUENTE CUSCATLAN','1107',3,'.2.11.1107.110704.					',''),('110705','SAN PEDRO','1107',3,'.2.11.1107.110705.					',''),('110706','EL CARAGUAL','1107',3,'.2.11.1107.110706.					',''),('110707','EL OJUSHTE','1107',3,'.2.11.1107.110707.					',''),('110708','EL TECOMATAL','1107',3,'.2.11.1107.110708.					',''),('110709','POTRERO DE JOCO','1107',3,'.2.11.1107.110709.					',''),('110710','SITIO SAN ANTONIO','1107',3,'.2.11.1107.110710.					',''),('1108','ESTANZUELAS','11',2,'.2.11.1108.					','11'),('110801','AGUACAYO','1108',3,'.2.11.1108.110801.					',''),('110802','BOLIVAR','1108',3,'.2.11.1108.110802.					',''),('110803','CABOS NEGROS','1108',3,'.2.11.1108.110803.					',''),('110804','CALIFORNIA','1108',3,'.2.11.1108.110804.					',''),('110805','CEIBA GACHA','1108',3,'.2.11.1108.110805.					',''),('110806','CRUZADILLA DE SAN JUAN','1108',3,'.2.11.1108.110806.					',''),('110807','EL CARMEN','1108',3,'.2.11.1108.110807.					',''),('110808','EL COYOLITO','1108',3,'.2.11.1108.110808.					',''),('110809','EL PARAISO','1108',3,'.2.11.1108.110809.					',''),('110810','HULE CHACHO','1108',3,'.2.11.1108.110810.					',''),('110811','LA CANOA','1108',3,'.2.11.1108.110811.					',''),('110812','LA CONCORDIA','1108',3,'.2.11.1108.110812.					',''),('110813','LA TIRANA','1108',3,'.2.11.1108.110813.					',''),('110814','LAS FLORES','1108',3,'.2.11.1108.110814.					',''),('110815','LOS CAMPOS','1108',3,'.2.11.1108.110815.					',''),('110816','LOS LIMONES','1108',3,'.2.11.1108.110816.					',''),('110817','NUEVA CALIFORNIA','1108',3,'.2.11.1108.110817.					',''),('110818','PUERTO LOS AVALOS','1108',3,'.2.11.1108.110818.					',''),('110819','ROQUINTE','1108',3,'.2.11.1108.110819.					',''),('110820','SALINAS DE SISIGUAYO','1108',3,'.2.11.1108.110820.					',''),('110821','SAN JOSE','1108',3,'.2.11.1108.110821.					',''),('110822','SAN JUAN DE LETRAN','1108',3,'.2.11.1108.110822.					',''),('110823','SAN JUAN DEL GOZO','1108',3,'.2.11.1108.110823.					',''),('110824','SAN JUDAS','1108',3,'.2.11.1108.110824.					',''),('110825','SAN MARCOS LEMPA','1108',3,'.2.11.1108.110825.					',''),('110826','SAN PEDRO','1108',3,'.2.11.1108.110826.					',''),('110827','TABURETE JAGUAL','1108',3,'.2.11.1108.110827.					',''),('110828','TIERRA BLANCA','1108',3,'.2.11.1108.110828.					',''),('110829','CARRIZAL','1108',3,'.2.11.1108.110829.					',''),('110830','EL CASTANO','1108',3,'.2.11.1108.110830.					',''),('110831','ISLA MENDEZ','1108',3,'.2.11.1108.110831.					',''),('110832','LA NORIA','1108',3,'.2.11.1108.110832.					',''),('110833','LAS ESPERANZA','1108',3,'.2.11.1108.110833.					',''),('110834','EL MARILLO','1108',3,'.2.11.1108.110834.					',''),('110835','SALINAS EL POTRERO','1108',3,'.2.11.1108.110835.					',''),('110836','ZAMORAN','1108',3,'.2.11.1108.110836.					',''),('110837','MONTECRISTO','1108',3,'.2.11.1108.110837.					',''),('110838','TABURETE LOS CLAROS','1108',3,'.2.11.1108.110838.					',''),('110839','SAN ANTONIO POTRERIO','1108',3,'.2.11.1108.110839.					',''),('1109','JIQUILISCO','11',2,'.2.11.1109.					','11'),('110901','EL AMATON','1109',3,'.2.11.1109.110901.					',''),('110902','EL CHAGUITE','1109',3,'.2.11.1109.110902.					',''),('110903','EL NISPERO','1109',3,'.2.11.1109.110903.					',''),('110904','LLANO DE CHILAM','1109',3,'.2.11.1109.110904.					',''),('110905','LOMA DE LA CRUZ','1109',3,'.2.11.1109.110905.					',''),('110906','TEPESQUILLO ALTO','1109',3,'.2.11.1109.110906.					',''),('110907','TEPESQUILLO BAJO','1109',3,'.2.11.1109.110907.					',''),('110908','LLANO EL CHILAMATE','1109',3,'.2.11.1109.110908.					',''),('110909','LLANO GRANDE DE JUCUAPA','1109',3,'.2.11.1109.110909.					',''),('110910','SANTA CRUZ','1109',3,'.2.11.1109.110910.					',''),('1110','JUCUAPA','11',2,'.2.11.1110.					','11'),('111001','EL JICARO','1110',3,'.2.11.1110.111001.					',''),('111002','EL JUTAL','1110',3,'.2.11.1110.111002.					',''),('111003','EL LLANO','1110',3,'.2.11.1110.111003.					',''),('111004','EL PROGRESO','1110',3,'.2.11.1110.111004.					',''),('111005','EL ZAPOTE','1110',3,'.2.11.1110.111005.					',''),('111006','LA CRUZ','1110',3,'.2.11.1110.111006.					',''),('111007','SAMURIA','1110',3,'.2.11.1110.111007.					',''),('1111','JUCUARAN','11',2,'.2.11.1111.					','11'),('111101','EL CAULOTE','1111',3,'.2.11.1111.111101.					',''),('111102','EL JICARO','1111',3,'.2.11.1111.111102.					',''),('111103','EL JOCOTILLO','1111',3,'.2.11.1111.111103.					',''),('111104','LA PUERTA','1111',3,'.2.11.1111.111104.					',''),('111105','LOS HORCONES','1111',3,'.2.11.1111.111105.					',''),('111106','LOS TALNETES','1111',3,'.2.11.1111.111106.					',''),('111107','SAN BENITO','1111',3,'.2.11.1111.111107.					',''),('111108','SANTA ANITA','1111',3,'.2.11.1111.111108.					',''),('111109','LA MONTANITA','1111',3,'.2.11.1111.111109.					',''),('1112','MERCEDES UMANA','11',2,'.2.11.1112.					','11'),('111201','AZACUALPIA DE GUALCHO','1112',3,'.2.11.1112.111201.					',''),('111202','AZACUALPIA DE JOCO','1112',3,'.2.11.1112.111202.					',''),('111203','EL AMATILLO','1112',3,'.2.11.1112.111203.					',''),('111204','JOCOMONTIQUE','1112',3,'.2.11.1112.111204.					',''),('111205','LA ISLETA','1112',3,'.2.11.1112.111205.					',''),('111206','LAS LLAVES','1112',3,'.2.11.1112.111206.					',''),('111207','LA PALOMILLA','1112',3,'.2.11.1112.111207.					',''),('111208','LEPAZ','1112',3,'.2.11.1112.111208.					',''),('111209','NUEVO CARRIZAL','1112',3,'.2.11.1112.111209.					',''),('111210','POTRERO DE JOCO','1112',3,'.2.11.1112.111210.					',''),('111211','SAN JOSE','1112',3,'.2.11.1112.111211.					',''),('111212','LOS TALNETES','1112',3,'.2.11.1112.111212.					',''),('1113','NUEVA GRANADA','11',2,'.2.11.1113.					','11'),('111301','EL DELIRIO','1113',3,'.2.11.1113.111301.					',''),('111302','EL PALMITAL','1113',3,'.2.11.1113.111302.					',''),('111303','JOYA DEL PILAR','1113',3,'.2.11.1113.111303.					',''),('111304','LA POZA','1113',3,'.2.11.1113.111304.					',''),('111305','LAS TRANCAS','1113',3,'.2.11.1113.111305.					',''),('111306','LA BRENA','1113',3,'.2.11.1113.111306.					',''),('1114','OZATLAN','11',2,'.2.11.1114.					','11'),('111401','CORRAL DE MULAS','1114',3,'.2.11.1114.111401.					',''),('111402','EL ESPIRITU SANTO','1114',3,'.2.11.1114.111402.					',''),('111403','MADRE SAL','1114',3,'.2.11.1114.111403.					',''),('111404','SITIO DE SANTA LUCIA','1114',3,'.2.11.1114.111404.					',''),('1115','PUERTO EL TRIUNFO','11',2,'.2.11.1115.					','11'),('111501','BUENOS AIRES','1115',3,'.2.11.1115.111501.					',''),('111502','EL COROZO','1115',3,'.2.11.1115.111502.					',''),('111503','EL JICARO','1115',3,'.2.11.1115.111503.					',''),('111504','EL JOCOTE','1115',3,'.2.11.1115.111504.					',''),('111505','EL RODEO','1115',3,'.2.11.1115.111505.					',''),('111506','EL ZAPOTE','1115',3,'.2.11.1115.111506.					',''),('111507','GALINGAGUA','1115',3,'.2.11.1115.111507.					',''),('111508','LA MORA','1115',3,'.2.11.1115.111508.					',''),('111509','LA QUESERA','1115',3,'.2.11.1115.111509.					',''),('111510','LINARES','1115',3,'.2.11.1115.111510.					',''),('111511','LOS EUCALIPTOS','1115',3,'.2.11.1115.111511.					',''),('111512','LOS PLANES','1115',3,'.2.11.1115.111512.					',''),('111513','NOMBRE DE DIOS','1115',3,'.2.11.1115.111513.					',''),('111514','TRES CALLES','1115',3,'.2.11.1115.111514.					',''),('111515','LOS ARROZALES','1115',3,'.2.11.1115.111515.					',''),('111516','JOBAL ARROZALES','1115',3,'.2.11.1115.111516.					',''),('111517','LA CEIBA','1115',3,'.2.11.1115.111517.					',''),('111518','LINARES CAULOTA','1115',3,'.2.11.1115.111518.					',''),('1116','SAN AGUSTIN','11',2,'.2.11.1116.					','11'),('111601','EL ACEITUNO','1116',3,'.2.11.1116.111601.					',''),('111602','EL SEMILLERO','1116',3,'.2.11.1116.111602.					',''),('111603','LA CARIDAD','1116',3,'.2.11.1116.111603.					',''),('111604','LA TRONCONADA','1116',3,'.2.11.1116.111604.					',''),('111605','LOS CHARCOS','1116',3,'.2.11.1116.111605.					',''),('111606','LOS ESPINOS','1116',3,'.2.11.1116.111606.					',''),('111607','LAS CHARCAS','1116',3,'.2.11.1116.111607.					',''),('1117','SAN BUENAVENTURA','11',2,'.2.11.1117.					','11'),('111701','IGLESIA VIEJA','1117',3,'.2.11.1117.111701.					',''),('111702','MUNDO NUEVO','1117',3,'.2.11.1117.111702.					',''),('111703','SAN FRANCISCO','1117',3,'.2.11.1117.111703.					',''),('111704','LOS SALINAS','1117',3,'.2.11.1117.111704.					',''),('1118','SAN DIONISIO','11',2,'.2.11.1118.					','11'),('111801','CERRO EL NANZAL','1118',3,'.2.11.1118.111801.					',''),('111802','EL REBALSE','1118',3,'.2.11.1118.111802.					',''),('111803','EL VOLCAN','1118',3,'.2.11.1118.111803.					',''),('111804','JOYA ANCHA ABAJO','1118',3,'.2.11.1118.111804.					',''),('111805','JOYA ANCHA ARRIBA','1118',3,'.2.11.1118.111805.					',''),('111806','LAS CRUCES','1118',3,'.2.11.1118.111806.					',''),('111807','EL NISPERAL','1118',3,'.2.11.1118.111807.					',''),('111808','EL AMATE','1118',3,'.2.11.1118.111808.					',''),('111809','PIEDRA AGUA','1118',3,'.2.11.1118.111809.					',''),('1119','SAN FRANCISCO JAVIER','11',2,'.2.11.1119.					','11'),('111901','EL PALMO','1119',3,'.2.11.1119.111901.					',''),('111902','EL TABLON','1119',3,'.2.11.1119.111902.					',''),('111903','EL ZUNGANO','1119',3,'.2.11.1119.111903.					',''),('111904','LOS HORCONES','1119',3,'.2.11.1119.111904.					',''),('111905','LOS HORNOS','1119',3,'.2.11.1119.111905.					',''),('111906','LOS RIOS','1119',3,'.2.11.1119.111906.					',''),('111907','JOBAL HORNOS','1119',3,'.2.11.1119.111907.					',''),('111908','LA CRUZ','1119',3,'.2.11.1119.111908.					',''),('111909','LA PENA','1119',3,'.2.11.1119.111909.					',''),('1120','SANTA ELENA','11',2,'.2.11.1120.					','11'),('112001','MEJICAPA','1120',3,'.2.11.1120.112001.					',''),('112002','SAN FRANCISCO','1120',3,'.2.11.1120.112002.					',''),('1121','SANTA MARIA','11',2,'.2.11.1121.					','11'),('112101','BATRES','1121',3,'.2.11.1121.112101.					',''),('112102','CERRO VERDE','1121',3,'.2.11.1121.112102.					',''),('112103','EL TIGRE','1121',3,'.2.11.1121.112103.					',''),('112104','LAS FLORES','1121',3,'.2.11.1121.112104.					',''),('112105','LAS PLAYAS','1121',3,'.2.11.1121.112105.					',''),('112106','MEJICANOS','1121',3,'.2.11.1121.112106.					',''),('112107','EL MARQUEZADO','1121',3,'.2.11.1121.112107.					',''),('112108','LOMAS DE LOS GONZALEZ','1121',3,'.2.11.1121.112108.					',''),('1122','SANTIAGO DE MARIA','11',2,'.2.11.1122.					','11'),('112201','CERRO VERDE','1122',3,'.2.11.1122.112201.					',''),('112202','EL JICARO','1122',3,'.2.11.1122.112202.					',''),('112203','LOS CHAPETONES','1122',3,'.2.11.1122.112203.					',''),('112204','LOS HORCONES','1122',3,'.2.11.1122.112204.					',''),('112205','PASO DE GUALACHE','1122',3,'.2.11.1122.112205.					',''),('1123','TECAPAN','11',2,'.2.11.1123.					','11'),('112301','BUENA VISTA','1123',3,'.2.11.1123.112301.					',''),('112302','EL CERRITO','1123',3,'.2.11.1123.112302.					',''),('112303','EL TRILLO','1123',3,'.2.11.1123.112303.					',''),('112304','LA JOYA DE TOMASICO','1123',3,'.2.11.1123.112304.					',''),('112305','LA LAGUNA','1123',3,'.2.11.1123.112305.					',''),('112306','LA PRESA','1123',3,'.2.11.1123.112306.					',''),('112307','LAS SALINAS','1123',3,'.2.11.1123.112307.					',''),('112308','EL OBRAJUELO','1123',3,'.2.11.1123.112308.					',''),('112309','PALO GALAN','1123',3,'.2.11.1123.112309.					',''),('112310','SANTA BARBARA','1123',3,'.2.11.1123.112310.					',''),('112311','TALPETATE','1123',3,'.2.11.1123.112311.					',''),('112312','EL OJUSTE','1123',3,'.2.11.1123.112312.					',''),('112313','LA PENA','1123',3,'.2.11.1123.112313.					',''),('112314','OJO DE AGUA','1123',3,'.2.11.1123.112314.					',''),('112315','HACIENDA LA CARRERA','1123',3,'.2.11.1123.112315.					',''),('112316','PUERTO PARADA','1123',3,'.2.11.1123.112316.					',''),('112317','OBRAJUELO','1123',3,'.2.11.1123.112317.					',''),('112318','LAZO','1123',3,'.2.11.1123.112318.					',''),('112319','LAS CONCHAS','1123',3,'.2.11.1123.112319.					',''),('12','SAN MIGUEL','2',1,'.2.12.					',''),('1201','SAN MIGUEL','12',2,'.2.12.1201.					','12'),('120101','LA CEIBITA','1201',3,'.2.12.1201.120101.					',''),('120102','LA ORILLA','1201',3,'.2.12.1201.120102.					',''),('120103','MIRACAPA','1201',3,'.2.12.1201.120103.					',''),('120104','ROSAS NACASPILO','1201',3,'.2.12.1201.120104.					',''),('120105','SOLEDAD TERRERO','1201',3,'.2.12.1201.120105.					',''),('1202','CAROLINA','12',2,'.2.12.1202.					','12'),('120201','BELEN','1202',3,'.2.12.1202.120201.					',''),('120202','LLANO EL ANGEL','1202',3,'.2.12.1202.120202.					',''),('120203','NUEVO PORVENIR','1202',3,'.2.12.1202.120203.					',''),('120204','SAN CRISTOBAL','1202',3,'.2.12.1202.120204.					',''),('120205','SAN JUAN','1202',3,'.2.12.1202.120205.					',''),('120206','SAN LUISITO','1202',3,'.2.12.1202.120206.					',''),('120207','SAN MATIAS','1202',3,'.2.12.1202.120207.					',''),('120208','TEPONAHUASTE','1202',3,'.2.12.1202.120208.					',''),('120209','GUANASTE','1202',3,'.2.12.1202.120209.					',''),('120210','LAS TORRECILLAS','1202',3,'.2.12.1202.120210.					',''),('120211','LA MONTANITA','1202',3,'.2.12.1202.120211.					',''),('1203','CIUDAD BARRIOS','12',2,'.2.12.1203.					','12'),('120301','CANDELARIA','1203',3,'.2.12.1203.120301.					',''),('120302','EL COLORADO','1203',3,'.2.12.1203.120302.					',''),('120303','PLATANARILLO','1203',3,'.2.12.1203.120303.					',''),('120304','EL HORMIGUERO','1203',3,'.2.12.1203.120304.					',''),('120305','EL JICARAL','1203',3,'.2.12.1203.120305.					',''),('1204','COMACARAN','12',2,'.2.12.1204.					','12'),('120401','CERCAS DE PIEDRA','1204',3,'.2.12.1204.120401.					',''),('120402','LA TRINIDAD','1204',3,'.2.12.1204.120402.					',''),('120403','LOS AMATES','1204',3,'.2.12.1204.120403.					',''),('120404','SAN JERONIMO','1204',3,'.2.12.1204.120404.					',''),('120405','SAN PEDRO','1204',3,'.2.12.1204.120405.					',''),('120406','CUALAMA','1204',3,'.2.12.1204.120406.					',''),('1205','CHAPELTIQUE','12',2,'.2.12.1205.					','12'),('120501','BOQUERON','1205',3,'.2.12.1205.120501.					',''),('120502','CHAMBALA','1205',3,'.2.12.1205.120502.					',''),('120503','CONACASTAL','1205',3,'.2.12.1205.120503.					',''),('120504','COPINOL PRIMERO','1205',3,'.2.12.1205.120504.					',''),('120505','COPINOL SEGUNDO','1205',3,'.2.12.1205.120505.					',''),('120506','JOCOTE DULCE','1205',3,'.2.12.1205.120506.					',''),('120507','LA CRUZ PRIMERA','1205',3,'.2.12.1205.120507.					',''),('120508','LA CRUZ SEGUNDA','1205',3,'.2.12.1205.120508.					',''),('120509','LAS MARIAS','1205',3,'.2.12.1205.120509.					',''),('120510','LAS MESAS','1205',3,'.2.12.1205.120510.					',''),('120511','LOS PLANES PRIMERO','1205',3,'.2.12.1205.120511.					',''),('120512','LOS PLANES SEGUNDO','1205',3,'.2.12.1205.120512.					',''),('120513','LOS PLANES TERCERO','1205',3,'.2.12.1205.120513.					',''),('120514','OJO DE AGUA','1205',3,'.2.12.1205.120514.					',''),('120515','OROMONTIQUE','1205',3,'.2.12.1205.120515.					',''),('120516','SAN ANTONIO','1205',3,'.2.12.1205.120516.					',''),('120517','ZARAGOZA','1205',3,'.2.12.1205.120517.					',''),('120518','EL JOCOTE SAN ISIDRO','1205',3,'.2.12.1205.120518.					',''),('120519','LA PENA','1205',3,'.2.12.1205.120519.					',''),('120520','SAN PEDRO ARENALES','1205',3,'.2.12.1205.120520.					',''),('1206','CHINAMECA','12',2,'.2.12.1206.					','12'),('120601','CHILANGUERA','1206',3,'.2.12.1206.120601.					',''),('120602','EL CAPULIN','1206',3,'.2.12.1206.120602.					',''),('120603','GUADALUPE','1206',3,'.2.12.1206.120603.					',''),('120604','HOJA DE SAL','1206',3,'.2.12.1206.120604.					',''),('120605','LA ESTRECHURA','1206',3,'.2.12.1206.120605.					',''),('120606','NUEVA CONCEPCION','1206',3,'.2.12.1206.120606.					',''),('120607','SAN JOSE GUALOSO','1206',3,'.2.12.1206.120607.					',''),('120608','SAN PEDRO','1206',3,'.2.12.1206.120608.					',''),('120609','TIERRA BLANCA','1206',3,'.2.12.1206.120609.					',''),('120610','LLANO DE LAS ROSAS','1206',3,'.2.12.1206.120610.					',''),('120611','SAN RAMON','1206',3,'.2.12.1206.120611.					',''),('120613','EL CUCO','1206',3,'.2.12.1206.120613.					',''),('1207','CHIRILAGUA','12',2,'.2.12.1207.					','12'),('120701','CALLE NUEVA','1207',3,'.2.12.1207.120701.					',''),('120702','LLANO DEL COYOL','1207',3,'.2.12.1207.120702.					',''),('120703','MOROPALA','1207',3,'.2.12.1207.120703.					',''),('120704','PRIMAVERA','1207',3,'.2.12.1207.120704.					',''),('120705','EL BORBOLLON','1207',3,'.2.12.1207.120705.					',''),('1208','EL TRANSITO','12',2,'.2.12.1208.					','12'),('120801','AMAYA','1208',3,'.2.12.1208.120801.					',''),('120802','CONCEPCION','1208',3,'.2.12.1208.120802.					',''),('120803','EL JICARO','1208',3,'.2.12.1208.120803.					',''),('120804','EL NANCITO','1208',3,'.2.12.1208.120804.					',''),('120805','EL PALON','1208',3,'.2.12.1208.120805.					',''),('120806','LAS VENTAS','1208',3,'.2.12.1208.120806.					',''),('120807','SAN FRANCISCO','1208',3,'.2.12.1208.120807.					',''),('120808','SANTA BARBARA','1208',3,'.2.12.1208.120808.					',''),('120809','VALENCIA','1208',3,'.2.12.1208.120809.					',''),('1209','LOLOTIQUE','12',2,'.2.12.1209.					','12'),('120901','EL CERRO','1209',3,'.2.12.1209.120901.					',''),('120902','EL JOBO','1209',3,'.2.12.1209.120902.					',''),('120903','EL PAPALON','1209',3,'.2.12.1209.120903.					',''),('120904','EL PLATANAR','1209',3,'.2.12.1209.120904.					',''),('120905','EL RODEO','1209',3,'.2.12.1209.120905.					',''),('120906','SALAMAR','1209',3,'.2.12.1209.120906.					',''),('120907','LA ESTANCIA','1209',3,'.2.12.1209.120907.					',''),('120908','LA FRAGUA','1209',3,'.2.12.1209.120908.					',''),('120909','LOS EJIDOS','1209',3,'.2.12.1209.120909.					',''),('120910','SANTA BARBARA','1209',3,'.2.12.1209.120910.					',''),('120911','LA FRAGUA','1209',3,'.2.12.1209.120911.					',''),('120912','TONGOLONA','1209',3,'.2.12.1209.120912.					',''),('120913','VALLE ALEGRE','1209',3,'.2.12.1209.120913.					',''),('1210','MONCAGUA','12',2,'.2.12.1210.					','12'),('121001','PLANES DE SAN SEBASTIAN','1210',3,'.2.12.1210.121001.					',''),('121002','SAN LUIS','1210',3,'.2.12.1210.121002.					',''),('1211','NUEVA GUADALUPE','12',2,'.2.12.1211.					','12'),('121101','JARDIN','1211',3,'.2.12.1211.121101.					',''),('121102','OJEO','1211',3,'.2.12.1211.121102.					',''),('121103','QUESERAS','1211',3,'.2.12.1211.121103.					',''),('121104','SAN SEBASTIAN','1211',3,'.2.12.1211.121104.					',''),('121105','LAURELES','1211',3,'.2.12.1211.121105.					',''),('121106','CUCURUCHO','1211',3,'.2.12.1211.121106.					',''),('121107','MONTECILLO','1211',3,'.2.12.1211.121107.					',''),('1212','NUEVO EDEN DE SAN JUAN','12',2,'.2.12.1212.					','12'),('121201','EL OBRAJUELO','1212',3,'.2.12.1212.121201.					',''),('121202','EL TAMBORAL','1212',3,'.2.12.1212.121202.					',''),('121203','SAN ANTONIO','1212',3,'.2.12.1212.121203.					',''),('121204','SAN JOSE','1212',3,'.2.12.1212.121204.					',''),('1213','QUELEPA','12',2,'.2.12.1213.					','12'),('121301','SAN DIEGO','1213',3,'.2.12.1213.121301.					',''),('121302','SAN MARCOS','1213',3,'.2.12.1213.121302.					',''),('1214','SAN ANTONIO','12',2,'.2.12.1214.					','12'),('121401','LA JOYA','1214',3,'.2.12.1214.121401.					',''),('121402','LA LAGUNA','1214',3,'.2.12.1214.121402.					',''),('121403','QUEBRACHO','1214',3,'.2.12.1214.121403.					',''),('121404','SAN JERONIMO','1214',3,'.2.12.1214.121404.					',''),('1215','SAN GERARDO','12',2,'.2.12.1215.					','12'),('121501','CANDELARIA','1215',3,'.2.12.1215.121501.					',''),('121502','JOYA DE VENTURA','1215',3,'.2.12.1215.121502.					',''),('121503','LA CEIBA','1215',3,'.2.12.1215.121503.					',''),('121504','LA MORITA','1215',3,'.2.12.1215.121504.					',''),('121505','SAN JULIAN','1215',3,'.2.12.1215.121505.					',''),('1216','SAN JORGE','12',2,'.2.12.1216.					','12'),('121601','EL JUNQUILLO','1216',3,'.2.12.1216.121601.					',''),('121602','OSTUCAL','1216',3,'.2.12.1216.121602.					',''),('121603','SAN ANTONIO','1216',3,'.2.12.1216.121603.					',''),('121604','SAN JUAN','1216',3,'.2.12.1216.121604.					',''),('1217','SAN LUIS DE LA REINA','12',2,'.2.12.1217.					','12'),('121701','ALTOMIRO','1217',3,'.2.12.1217.121701.					',''),('121702','ANCHICO','1217',3,'.2.12.1217.121702.					',''),('121703','CERRO BONITO','1217',3,'.2.12.1217.121703.					',''),('121704','CONCEPCION COROZAL','1217',3,'.2.12.1217.121704.					',''),('121705','EL AMATE','1217',3,'.2.12.1217.121705.					',''),('121706','EL BRAZO','1217',3,'.2.12.1217.121706.					',''),('121707','EL DELIRIO','1217',3,'.2.12.1217.121707.					',''),('121708','EL DIVISADERO','1217',3,'.2.12.1217.121708.					',''),('121709','EL HAVILLAL','1217',3,'.2.12.1217.121709.					',''),('121710','EL JUTE','1217',3,'.2.12.1217.121710.					',''),('121711','EL PAPALON','1217',3,'.2.12.1217.121711.					',''),('121712','EL PROGRESO','1217',3,'.2.12.1217.121712.					',''),('121713','EL SITIO','1217',3,'.2.12.1217.121713.					',''),('121714','EL TECOMATAL','1217',3,'.2.12.1217.121714.					',''),('121715','EL VOLCAN','1217',3,'.2.12.1217.121715.					',''),('121716','EL ZAMORAN','1217',3,'.2.12.1217.121716.					',''),('121717','HATO NUEVO','1217',3,'.2.12.1217.121717.					',''),('121718','JALACATAL','1217',3,'.2.12.1217.121718.					',''),('121719','LA CANOA','1217',3,'.2.12.1217.121719.					',''),('121720','LA PUERTA','1217',3,'.2.12.1217.121720.					',''),('121721','LA TRINIDAD','1217',3,'.2.12.1217.121721.					',''),('121722','LAS DELICIAS','1217',3,'.2.12.1217.121722.					',''),('121723','LAS LOMITAS','1217',3,'.2.12.1217.121723.					',''),('121724','MIRAFLORES','1217',3,'.2.12.1217.121724.					',''),('121725','MONTE GRANDE','1217',3,'.2.12.1217.121725.					',''),('121726','SAN ANDRES','1217',3,'.2.12.1217.121726.					',''),('121727','SAN ANTONIO CHAVEZ','1217',3,'.2.12.1217.121727.					',''),('121728','SAN ANTONIO SILVA','1217',3,'.2.12.1217.121728.					',''),('121729','SAN CARLOS','1217',3,'.2.12.1217.121729.					',''),('121730','SAN JACINTO','1217',3,'.2.12.1217.121730.					',''),('121731','SANTA INES','1217',3,'.2.12.1217.121731.					',''),('121732','EL NINO','1217',3,'.2.12.1217.121732.					',''),('121733','AGUA ZARCA','1217',3,'.2.12.1217.121733.					',''),('1218','SAN RAFAEL ORIENTE','12',2,'.2.12.1218.					','12'),('121801','LOS ZELAYA','1218',3,'.2.12.1218.121801.					',''),('121802','PIEDRA AZUL','1218',3,'.2.12.1218.121802.					',''),('121803','RODEO DE PEDRON','1218',3,'.2.12.1218.121803.					',''),('121804','SANTA CLARA','1218',3,'.2.12.1218.121804.					',''),('1219','SESORI','12',2,'.2.12.1219.					','12'),('121901','CHARLACA','1219',3,'.2.12.1219.121901.					',''),('121902','EL ESPIRITU SANTO','1219',3,'.2.12.1219.121902.					',''),('121903','EL TABLON','1219',3,'.2.12.1219.121903.					',''),('121904','LAS MESAS','1219',3,'.2.12.1219.121904.					',''),('121905','MINITAS','1219',3,'.2.12.1219.121905.					',''),('121906','SAN JACINTO','1219',3,'.2.12.1219.121906.					',''),('121907','SAN SEBASTIAN','1219',3,'.2.12.1219.121907.					',''),('121908','SANTA ROSA','1219',3,'.2.12.1219.121908.					',''),('121909','MANAGUARA','1219',3,'.2.12.1219.121909.					',''),('121910','MAZATEPEQUE','1219',3,'.2.12.1219.121910.					',''),('1220','ULUAZAPA','12',2,'.2.12.1220.					','12'),('122001','JUAN YANEZ','1220',3,'.2.12.1220.122001.					',''),('122002','LOS PILONES','1220',3,'.2.12.1220.122002.					',''),('122003','RIO DE VARGAS','1220',3,'.2.12.1220.122003.					',''),('122004','RIO VARGAS','1220',3,'.2.12.1220.122004.					',''),('13','MORAZAN','2',1,'.2.13.					',''),('1301','SAN FRANCISCO GOTERA','13',2,'.2.13.1301.					','13'),('130101','EL CARRIZAL','1301',3,'.2.13.1301.130101.					',''),('130102','NAHUATERIQUE','1301',3,'.2.13.1301.130102.					',''),('130103','PUEBLO VIEJO','1301',3,'.2.13.1301.130103.					',''),('130104','TIERRA COLORADA','1301',3,'.2.13.1301.130104.					',''),('1302','ARAMBALA','13',2,'.2.13.1302.					','13'),('130201','AGUA BLANCA','1302',3,'.2.13.1302.130201.					',''),('130202','CALAVERA','1302',3,'.2.13.1302.130202.					',''),('130203','JUNQUILLO','1302',3,'.2.13.1302.130203.					',''),('130204','OCOTILLO','1302',3,'.2.13.1302.130204.					',''),('130205','LA ESTANCIA','1302',3,'.2.13.1302.130205.					',''),('130206','SUNSULACA','1302',3,'.2.13.1302.130206.					',''),('130207','GUACHIPILIN','1302',3,'.2.13.1302.130207.					',''),('1303','CACAOPERA','13',2,'.2.13.1303.					','13'),('130301','CORRALITO','1303',3,'.2.13.1303.130301.					',''),('130302','HONDABLE','1303',3,'.2.13.1303.130302.					',''),('130303','LAGUNA','1303',3,'.2.13.1303.130303.					',''),('130304','SAN FELIPE','1303',3,'.2.13.1303.130304.					',''),('130305','VARILLA NEGRA','1303',3,'.2.13.1303.130305.					',''),('1304','CORINTO','13',2,'.2.13.1304.					','13'),('130401','JOYA DEL MATAZANO','1304',3,'.2.13.1304.130401.					',''),('130402','LAJITAS','1304',3,'.2.13.1304.130402.					',''),('130403','PIEDRA PARADA','1304',3,'.2.13.1304.130403.					',''),('130404','EL CHAPARRAL','1304',3,'.2.13.1304.130404.					',''),('130405','EL PEDERNAL','1304',3,'.2.13.1304.130405.					',''),('1305','CHILANGA','13',2,'.2.13.1305.					','13'),('130501','EL VOLCAN','1305',3,'.2.13.1305.130501.					',''),('130502','LA CUCHILLA','1305',3,'.2.13.1305.130502.					',''),('1306','DELICIAS DE CONCEPCION','13',2,'.2.13.1306.					','13'),('130601','LA CANADA','1306',3,'.2.13.1306.130601.					',''),('130602','LLANO DE SANTIAGO','1306',3,'.2.13.1306.130602.					',''),('130603','LOMA LARGA','1306',3,'.2.13.1306.130603.					',''),('130604','LOMA TENDIDA','1306',3,'.2.13.1306.130604.					',''),('130605','SAN PEDRO','1306',3,'.2.13.1306.130605.					',''),('130606','SANTA ANITA','1306',3,'.2.13.1306.130606.					',''),('130607','VILLA MODELO','1306',3,'.2.13.1306.130607.					',''),('130608','NOMBRE DE JESUS','1306',3,'.2.13.1306.130608.					',''),('1307','EL DIVISADERO','13',2,'.2.13.1307.					','13'),('130701','LA LAGUNA','1307',3,'.2.13.1307.130701.					',''),('130702','OJOS DE AGUA','1307',3,'.2.13.1307.130702.					',''),('1308','EL ROSARIO','13',2,'.2.13.1308.					','13'),('130801','LA JOYA','1308',3,'.2.13.1308.130801.					',''),('130802','SAN LUCAS','1308',3,'.2.13.1308.130802.					',''),('1309','GUALOCOCTI','13',2,'.2.13.1309.					','13'),('130901','MAIGUERA','1309',3,'.2.13.1309.130901.					',''),('130902','PAJIGUA','1309',3,'.2.13.1309.130902.					',''),('130903','SAN BARTOLO','1309',3,'.2.13.1309.130903.					',''),('130904','EL VOLCAN','1309',3,'.2.13.1309.130904.					',''),('130905','ABELINES','1309',3,'.2.13.1309.130905.					',''),('130906','EL SIRIGUAL','1309',3,'.2.13.1309.130906.					',''),('1310','GUATAJIAGUA','13',2,'.2.13.1310.					','13'),('131001','PATURLA','1310',3,'.2.13.1310.131001.					',''),('131002','VOLCANCILLO','1310',3,'.2.13.1310.131002.					',''),('131003','ZAPOTAL','1310',3,'.2.13.1310.131003.					',''),('1311','JOATECA','13',2,'.2.13.1311.					','13'),('131101','EL RODEO','1311',3,'.2.13.1311.131101.					',''),('131102','EL VOLCANCILLO','1311',3,'.2.13.1311.131102.					',''),('1312','JOCOAITIQUE','13',2,'.2.13.1312.					','13'),('131201','FLAMENCO','1312',3,'.2.13.1312.131201.					',''),('131202','GUACHIPILIN','1312',3,'.2.13.1312.131202.					',''),('131203','LAGUNETAS','1312',3,'.2.13.1312.131203.					',''),('131204','LAS MARIAS','1312',3,'.2.13.1312.131204.					',''),('131205','LAURELES','1312',3,'.2.13.1312.131205.					',''),('131206','SAN FELIPE','1312',3,'.2.13.1312.131206.					',''),('131207','SAN JOSE','1312',3,'.2.13.1312.131207.					',''),('131208','SAN JUAN','1312',3,'.2.13.1312.131208.					',''),('1313','JOCORO','13',2,'.2.13.1313.					','13'),('131301','MANZANILLA','1313',3,'.2.13.1313.131301.					',''),('131302','GUALINDO ARRIBA','1313',3,'.2.13.1313.131302.					',''),('131303','GUALINDO CENTRO','1313',3,'.2.13.1313.131303.					',''),('131304','GUALINDO ABAJO','1313',3,'.2.13.1313.131304.					',''),('1314','LOLOTIQUILLO','13',2,'.2.13.1314.					','13'),('131401','CERRO PANDO','1314',3,'.2.13.1314.131401.					',''),('131402','LA JOYA','1314',3,'.2.13.1314.131402.					',''),('131403','LA SOLEDAD','1314',3,'.2.13.1314.131403.					',''),('131404','LA GUACAMAYA','1314',3,'.2.13.1314.131404.					',''),('1315','MEANGUERA','13',2,'.2.13.1315.					','13'),('131501','AGUA ZARCA','1315',3,'.2.13.1315.131501.					',''),('131502','HUILIHUISTE','1315',3,'.2.13.1315.131502.					',''),('131503','LA MONTANA','1315',3,'.2.13.1315.131503.					',''),('131504','CERRO COYOL','1315',3,'.2.13.1315.131504.					',''),('1316','OSICALA','13',2,'.2.13.1316.					','13'),('131601','CASA BLANCA','1316',3,'.2.13.1316.131601.					',''),('131602','LAS TROJAS','1316',3,'.2.13.1316.131602.					',''),('131603','SABANETAS','1316',3,'.2.13.1316.131603.					',''),('1317','PERQUIN','13',2,'.2.13.1317.					','13'),('131701','LA JAGUA','1317',3,'.2.13.1317.131701.					',''),('131702','SAN DIEGO','1317',3,'.2.13.1317.131702.					',''),('131703','SAN MARCOS','1317',3,'.2.13.1317.131703.					',''),('131704','VALLE NUEVO','1317',3,'.2.13.1317.131704.					',''),('1318','SAN CARLOS','13',2,'.2.13.1318.					','13'),('131801','AZACUALPA','1318',3,'.2.13.1318.131801.					',''),('131802','CANAVERALES','1318',3,'.2.13.1318.131802.					',''),('1319','SAN FERNANDO','13',2,'.2.13.1319.					','13'),('131901','SAN FRANCISQUITO','1319',3,'.2.13.1319.131901.					',''),('131902','SAN JOSE','1319',3,'.2.13.1319.131902.					',''),('131903','EL TRIUNFO','1319',3,'.2.13.1319.131903.					',''),('131904','CACAHUATALEJO','1319',3,'.2.13.1319.131904.					',''),('131905','EL ROSARIO','1319',3,'.2.13.1319.131905.					',''),('131906','EL NORTE','1319',3,'.2.13.1319.131906.					',''),('1320','SAN ISIDRO','13',2,'.2.13.1320.					','13'),('132001','EL ROSARIO','1320',3,'.2.13.1320.132001.					',''),('132002','PIEDRA PARADA','1320',3,'.2.13.1320.132002.					',''),('1321','SAN SIMON','13',2,'.2.13.1321.					','13'),('132101','EL CARRIZAL','1321',3,'.2.13.1321.132101.					',''),('132102','EL CERRO','1321',3,'.2.13.1321.132102.					',''),('132103','LAS QUEBRADAS','1321',3,'.2.13.1321.132103.					',''),('132104','POTRERO DE ADENTRO','1321',3,'.2.13.1321.132104.					',''),('132105','VALLE GRANDE','1321',3,'.2.13.1321.132105.					',''),('132106','SAN FRANCISCO','1321',3,'.2.13.1321.132106.					',''),('1322','SENSEMBRA','13',2,'.2.13.1322.					','13'),('132201','EL LIMON','1322',3,'.2.13.1322.132201.					',''),('132202','EL RODEO','1322',3,'.2.13.1322.132202.					',''),('1323','SOCIEDAD','13',2,'.2.13.1323.					','13'),('132301','ANIMAS','1323',3,'.2.13.1323.132301.					',''),('132302','CALPULES','1323',3,'.2.13.1323.132302.					',''),('132303','CANDELARIA','1323',3,'.2.13.1323.132303.					',''),('132304','EL TABLON','1323',3,'.2.13.1323.132304.					',''),('132305','LA JOYA','1323',3,'.2.13.1323.132305.					',''),('132306','EL BEJUCAL','1323',3,'.2.13.1323.132306.					',''),('132307','LA LABRANZA','1323',3,'.2.13.1323.132307.					',''),('132308','EL PENON','1323',3,'.2.13.1323.132308.					',''),('1324','TOROLA','13',2,'.2.13.1324.					','13'),('132401','AGUA ZARCA','1324',3,'.2.13.1324.132401.					',''),('132402','CERRITOS','1324',3,'.2.13.1324.132402.					',''),('132403','TIJERETAS','1324',3,'.2.13.1324.132403.					',''),('132404','EL PROGRESO','1324',3,'.2.13.1324.132404.					',''),('1325','YAMABAL','13',2,'.2.13.1325.					','13'),('132501','JOYA DEL MATAZANO','1325',3,'.2.13.1325.132501.					',''),('132502','SAN FRANCISQUITO','1325',3,'.2.13.1325.132502.					',''),('132503','SAN JUAN','1325',3,'.2.13.1325.132503.					',''),('132504','LOMA EL CHILE','1325',3,'.2.13.1325.132504.					',''),('1326','YOLOAIQUIN','13',2,'.2.13.1326.					','13'),('132601','EL ACEITUNO','1326',3,'.2.13.1326.132601.					',''),('132602','EL VOLCAN','1326',3,'.2.13.1326.132602.					',''),('14','LA UNION','2',1,'.2.14.					',''),('1401','LA UNION','14',2,'.2.14.1401.					','14'),('140101','AGUA BLANCA','1401',3,'.2.14.1401.140101.					',''),('140102','EL CARBONAL','1401',3,'.2.14.1401.140102.					',''),('140103','EL TIZATE','1401',3,'.2.14.1401.140103.					',''),('140104','TERRERITOS','1401',3,'.2.14.1401.140104.					',''),('140105','HUERTA VIEJA','1401',3,'.2.14.1401.140105.					',''),('140106','TULIMA','1401',3,'.2.14.1401.140106.					',''),('140107','EL CEDRO','1401',3,'.2.14.1401.140107.					',''),('140108','CORDONCILLO','1401',3,'.2.14.1401.140108.					',''),('1402','ANAMOROS','14',2,'.2.14.1402.					','14'),('140201','ALBORNOZ','1402',3,'.2.14.1402.140201.					',''),('140202','EL TRANSITO','1402',3,'.2.14.1402.140202.					',''),('140203','GUADALUPE','1402',3,'.2.14.1402.140203.					',''),('140204','LA PAZ','1402',3,'.2.14.1402.140204.					',''),('140205','LA RINCONADA','1402',3,'.2.14.1402.140205.					',''),('140206','NUEVA GUADALUPE','1402',3,'.2.14.1402.140206.					',''),('140207','SANTA LUCIA','1402',3,'.2.14.1402.140207.					',''),('140208','CANDELARIA ALBORNOZ','1402',3,'.2.14.1402.140208.					',''),('140209','JOYAS LAS TUNAS','1402',3,'.2.14.1402.140209.					',''),('1403','BOLIVAR','14',2,'.2.14.1403.					','14'),('140301','EL GUAYABO','1403',3,'.2.14.1403.140301.					',''),('140302','EL MOLINO','1403',3,'.2.14.1403.140302.					',''),('140303','EL ZAPOTE','1403',3,'.2.14.1403.140303.					',''),('140304','GUERIPE','1403',3,'.2.14.1403.140304.					',''),('1404','CONCEPCION DE ORIENTE','14',2,'.2.14.1404.					','14'),('140401','CERRO EL JIOTE','1404',3,'.2.14.1404.140401.					',''),('140402','CONCHAGUITA','1404',3,'.2.14.1404.140402.					',''),('140403','EL CACAO','1404',3,'.2.14.1404.140403.					',''),('140404','EL CIPRES','1404',3,'.2.14.1404.140404.					',''),('140405','EL FARO','1404',3,'.2.14.1404.140405.					',''),('140406','EL PILON','1404',3,'.2.14.1404.140406.					',''),('140407','EL TAMARINDO','1404',3,'.2.14.1404.140407.					',''),('140408','HUISQUIL','1404',3,'.2.14.1404.140408.					',''),('140409','LOS ANGELES','1404',3,'.2.14.1404.140409.					',''),('140410','MAQUIGUE','1404',3,'.2.14.1404.140410.					',''),('140411','PLAYAS NEGRAS','1404',3,'.2.14.1404.140411.					',''),('140412','YOLOGUAL','1404',3,'.2.14.1404.140412.					',''),('140413','EL JAGUEY','1404',3,'.2.14.1404.140413.					',''),('140414','PIEDRAS BLANCAS','1404',3,'.2.14.1404.140414.					',''),('140415','PIEDRAS RAYADAS','1404',3,'.2.14.1404.140415.					',''),('140416','LLANO LOS PATOS','1404',3,'.2.14.1404.140416.					',''),('1405','CONCHAGUA','14',2,'.2.14.1405.					','14'),('140501','ALTO EL ROBLE','1405',3,'.2.14.1405.140501.					',''),('140502','CAULOTILLO','1405',3,'.2.14.1405.140502.					',''),('140503','EL GAVILAN','1405',3,'.2.14.1405.140503.					',''),('140504','EL PICHE','1405',3,'.2.14.1405.140504.					',''),('140505','EL TEJAR','1405',3,'.2.14.1405.140505.					',''),('140506','EL ZAPOTAL','1405',3,'.2.14.1405.140506.					',''),('140507','LOS CONEJOS','1405',3,'.2.14.1405.140507.					',''),('140508','OLOMEGA','1405',3,'.2.14.1405.140508.					',''),('140509','LAS PITAS','1405',3,'.2.14.1405.140509.					',''),('140510','SALALAGUA','1405',3,'.2.14.1405.140510.					',''),('140511','LA CANADA','1405',3,'.2.14.1405.140511.					',''),('1406','EL CARMEN','14',2,'.2.14.1406.					','14'),('140601','CANAIRE','1406',3,'.2.14.1406.140601.					',''),('140602','EL RINCON','1406',3,'.2.14.1406.140602.					',''),('140603','SANTA ROSITA','1406',3,'.2.14.1406.140603.					',''),('140604','TALPETATE','1406',3,'.2.14.1406.140604.					',''),('140605','SAN JUAN GUALARES','1406',3,'.2.14.1406.140605.					',''),('1407','EL SAUCE','14',2,'.2.14.1407.					','14'),('140701','EL CARAO','1407',3,'.2.14.1407.140701.					',''),('140702','LA LEONA','1407',3,'.2.14.1407.140702.					',''),('1408','INTIPUCA','14',2,'.2.14.1408.					','14'),('1409','LISLIQUE','14',2,'.2.14.1409.					','14'),('140901','AGUA FRIA','1409',3,'.2.14.1409.140901.					',''),('140902','GUAJINIQUIL','1409',3,'.2.14.1409.140902.					',''),('140903','HIGUERAS','1409',3,'.2.14.1409.140903.					',''),('140904','EL DERRUMBADO','1409',3,'.2.14.1409.140904.					',''),('140905','EL GUAJINIQUIL','1409',3,'.2.14.1409.140905.					',''),('140906','EL TERRERO','1409',3,'.2.14.1409.140906.					',''),('140907','LAS PILAS','1409',3,'.2.14.1409.140907.					',''),('1410','MEANGUERA DEL GOLFO','14',2,'.2.14.1410.					','14'),('141001','EL SALVADOR','1410',3,'.2.14.1410.141001.					',''),('141002','GUERRERO','1410',3,'.2.14.1410.141002.					',''),('141003','ISLA DE CONCHAGUITA','1410',3,'.2.14.1410.141003.					',''),('1411','NUEVA ESPARTA','14',2,'.2.14.1411.					','14'),('141101','EL PORTILLO','1411',3,'.2.14.1411.141101.					',''),('141102','HONDURITAS','1411',3,'.2.14.1411.141102.					',''),('141103','LAS MARIAS','1411',3,'.2.14.1411.141103.					',''),('141104','MONTECA','1411',3,'.2.14.1411.141104.					',''),('141105','TALPETATE','1411',3,'.2.14.1411.141105.					',''),('141106','OCOTILLO','1411',3,'.2.14.1411.141106.					',''),('1412','PASAQUINA','14',2,'.2.14.1412.					','14'),('141201','CERRO PELON','1412',3,'.2.14.1412.141201.					',''),('141202','EL AMATILLO','1412',3,'.2.14.1412.141202.					',''),('141203','EL REBALSE','1412',3,'.2.14.1412.141203.					',''),('141204','EL TABLON','1412',3,'.2.14.1412.141204.					',''),('141205','HORCONES','1412',3,'.2.14.1412.141205.					',''),('141206','PIEDRAS BLANCAS','1412',3,'.2.14.1412.141206.					',''),('141207','SAN EDUARDO','1412',3,'.2.14.1412.141207.					',''),('141208','SAN FELIPE','1412',3,'.2.14.1412.141208.					',''),('141209','SANTA CLARA','1412',3,'.2.14.1412.141209.					',''),('141210','VALLE AFUERA','1412',3,'.2.14.1412.141210.					',''),('141211','LOS CAMOTES','1412',3,'.2.14.1412.141211.					',''),('141212','EL PICACHO','1412',3,'.2.14.1412.141212.					',''),('1413','POLOROS','14',2,'.2.14.1413.					','14'),('141301','BOQUIN','1413',3,'.2.14.1413.141301.					',''),('141302','CARPINTERO','1413',3,'.2.14.1413.141302.					',''),('141303','LAJITAS','1413',3,'.2.14.1413.141303.					',''),('141304','EL OCOTE','1413',3,'.2.14.1413.141304.					',''),('141305','EL PUEBLO','1413',3,'.2.14.1413.141305.					',''),('141306','EL RODEO','1413',3,'.2.14.1413.141306.					',''),('141307','MALA LAJA','1413',3,'.2.14.1413.141307.					',''),('1414','SAN ALEJO','14',2,'.2.14.1414.					','14'),('141401','AGUA FRIA','1414',3,'.2.14.1414.141401.					',''),('141402','BOBADILLA','1414',3,'.2.14.1414.141402.					',''),('141403','COPALIO','1414',3,'.2.14.1414.141403.					',''),('141404','EL TAMARINDO','1414',3,'.2.14.1414.141404.					',''),('141405','HATO NUEVO','1414',3,'.2.14.1414.141405.					',''),('141406','LAS QUESERAS','1414',3,'.2.14.1414.141406.					',''),('141407','LOS JIOTES','1414',3,'.2.14.1414.141407.					',''),('141408','MOGOTILLO','1414',3,'.2.14.1414.141408.					',''),('141409','SAN JERONIMO','1414',3,'.2.14.1414.141409.					',''),('141410','SAN JOSE','1414',3,'.2.14.1414.141410.					',''),('141411','SANTA CRUZ','1414',3,'.2.14.1414.141411.					',''),('141412','TERRERO BLANCO','1414',3,'.2.14.1414.141412.					',''),('141413','TRINCHERAS','1414',3,'.2.14.1414.141413.					',''),('141414','MONTE VERDE','1414',3,'.2.14.1414.141414.					',''),('141415','CEIBILLAS','1414',3,'.2.14.1414.141415.					',''),('141416','EL CARAON','1414',3,'.2.14.1414.141416.					',''),('141417','EL TEMPISQUE','1414',3,'.2.14.1414.141417.					',''),('141418','PAVANA','1414',3,'.2.14.1414.141418.					',''),('141419','EL TIZATIO','1414',3,'.2.14.1414.141419.					',''),('141420','CERCOS DE PIEDRA','1414',3,'.2.14.1414.141420.					',''),('1415','SAN JOSE','14',2,'.2.14.1415.					','14'),('141501','EL SOMBRERITO','1415',3,'.2.14.1415.141501.					',''),('141502','EL ZAPOTE','1415',3,'.2.14.1415.141502.					',''),('141503','LA JOYA','1415',3,'.2.14.1415.141503.					',''),('141504','EL CHAGUITILLO','1415',3,'.2.14.1415.141504.					',''),('1416','SANTA ROSA DE LIMA','14',2,'.2.14.1416.					','14');
/*!40000 ALTER TABLE `municipios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ovisss`
--

DROP TABLE IF EXISTS `ovisss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ovisss` (
  `IdOvisss` int(11) NOT NULL AUTO_INCREMENT,
  `NumPatronal` varchar(45) NOT NULL,
  `Periodo` varchar(45) NOT NULL,
  `Correlativo` varchar(45) NOT NULL,
  `NombreCompleto` varchar(45) NOT NULL,
  `Vacaciones` varchar(45) NOT NULL,
  `PagosAdicionales` varchar(45) NOT NULL,
  `DiasTrabajados` varchar(45) NOT NULL,
  `HorasLaborales` varchar(45) NOT NULL,
  `DiasVacacion` varchar(45) NOT NULL,
  `CodigoObservacion` varchar(45) NOT NULL,
  `PeriodoOviss` varchar(45) NOT NULL,
  `MesOvisss` varchar(45) NOT NULL,
  PRIMARY KEY (`IdOvisss`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ovisss`
--

LOCK TABLES `ovisss` WRITE;
/*!40000 ALTER TABLE `ovisss` DISABLE KEYS */;
/*!40000 ALTER TABLE `ovisss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pais` (
  `IdPais` varchar(2) NOT NULL,
  `DescripcionPais` varchar(100) NOT NULL,
  PRIMARY KEY (`IdPais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES ('A1','Anonymous Proxy'),('A2','Satellite Provider'),('AD','Andorra'),('AE','United Arab Emirates'),('AF','Afghanistan'),('AG','Antigua and Barbuda'),('AI','Anguilla'),('AL','Albania'),('AM','Armenia'),('AO','Angola'),('AP','Asia/Pacific Region'),('AQ','Antarctica'),('AR','Argentina'),('AS','American Samoa'),('AT','Austria'),('AU','Australia'),('AW','Aruba'),('AX','Aland Islands'),('AZ','Azerbaijan'),('BA','Bosnia and Herzegovina'),('BB','Barbados'),('BD','Bangladesh'),('BE','Belgium'),('BF','Burkina Faso'),('BG','Bulgaria'),('BH','Bahrain'),('BI','Burundi'),('BJ','Benin'),('BL','Saint Barthelemy'),('BM','Bermuda'),('BN','Brunei Darussalam'),('BO','Bolivia'),('BQ','Bonair'),('BR','Brazil'),('BS','Bahamas'),('BT','Bhutan'),('BW','Botswana'),('BY','Belarus'),('BZ','Belize'),('CA','Canada'),('CC','Cocos (Keeling) Islands'),('CD','Cong'),('CF','Central African Republic'),('CG','Congo'),('CH','Switzerland'),('CI','Cote D\'Ivoire'),('CK','Cook Islands'),('CL','Chile'),('CM','Cameroon'),('CN','China'),('CO','Colombia'),('CR','Costa Rica'),('CU','Cuba'),('CV','Cape Verde'),('CW','Curacao'),('CX','Christmas Island'),('CY','Cyprus'),('CZ','Czech Republic'),('DE','Germany'),('DJ','Djibouti'),('DK','Denmark'),('DM','Dominica'),('DO','Dominican Republic'),('DZ','Algeria'),('EC','Ecuador'),('EE','Estonia'),('EG','Egypt'),('EH','Western Sahara'),('ER','Eritrea'),('ES','Spain'),('ET','Ethiopia'),('FI','Finland'),('FJ','Fiji'),('FK','Falkland Islands (Malvinas)'),('FM','Micronesi'),('FO','Faroe Islands'),('FR','France'),('GA','Gabon'),('GB','United Kingdom'),('GD','Grenada'),('GE','Georgia'),('GF','French Guiana'),('GG','Guernsey'),('GH','Ghana'),('GI','Gibraltar'),('GL','Greenland'),('GM','Gambia'),('GN','Guinea'),('GP','Guadeloupe'),('GQ','Equatorial Guinea'),('GR','Greece'),('GS','South Georgia and the South Sandwich Islands'),('GT','Guatemala'),('GU','Guam'),('GW','Guinea-Bissau'),('GY','Guyana'),('HK','Hong Kong'),('HN','Honduras'),('HR','Croatia'),('HT','Haiti'),('HU','Hungary'),('ID','Indonesia'),('IE','Ireland'),('IL','Israel'),('IM','Isle of Man'),('IN','India'),('IO','British Indian Ocean Territory'),('IQ','Iraq'),('IR','Ira'),('IS','Iceland'),('IT','Italy'),('JE','Jersey'),('JM','Jamaica'),('JO','Jordan'),('JP','Japan'),('KE','Kenya'),('KG','Kyrgyzstan'),('KH','Cambodia'),('KI','Kiribati'),('KM','Comoros'),('KN','Saint Kitts and Nevis'),('KP','Kore'),('KR','Kore'),('KW','Kuwait'),('KY','Cayman Islands'),('KZ','Kazakhstan'),('LA','Lao People\'s Democratic Republic'),('LB','Lebanon'),('LC','Saint Lucia'),('LI','Liechtenstein'),('LK','Sri Lanka'),('LR','Liberia'),('LS','Lesotho'),('LT','Lithuania'),('LU','Luxembourg'),('LV','Latvia'),('LY','Libya'),('MA','Morocco'),('MC','Monaco'),('MD','Moldov'),('ME','Montenegro'),('MF','Saint Martin'),('MG','Madagascar'),('MH','Marshall Islands'),('MK','Macedonia'),('ML','Mali'),('MM','Myanmar'),('MN','Mongolia'),('MO','Macau'),('MP','Northern Mariana Islands'),('MQ','Martinique'),('MR','Mauritania'),('MS','Montserrat'),('MT','Malta'),('MU','Mauritius'),('MV','Maldives'),('MW','Malawi'),('MX','Mexico'),('MY','Malaysia'),('MZ','Mozambique'),('NA','Namibia'),('NC','New Caledonia'),('NE','Niger'),('NF','Norfolk Island'),('NG','Nigeria'),('NI','Nicaragua'),('NL','Netherlands'),('NO','Norway'),('NP','Nepal'),('NR','Nauru'),('NU','Niue'),('NZ','New Zealand'),('OM','Oman'),('PA','Panama'),('PE','Peru'),('PF','French Polynesia'),('PG','Papua New Guinea'),('PH','Philippines'),('PK','Pakistan'),('PL','Poland'),('PM','Saint Pierre and Miquelon'),('PN','Pitcairn Islands'),('PR','Puerto Rico'),('PS','Palestinian Territory'),('PT','Portugal'),('PW','Palau'),('PY','Paraguay'),('QA','Qatar'),('RE','Reunion'),('RO','Romania'),('RS','Serbia'),('RU','Russian Federation'),('RW','Rwanda'),('SA','Saudi Arabia'),('SB','Solomon Islands'),('SC','Seychelles'),('SD','Sudan'),('SE','Sweden'),('SG','Singapore'),('SH','Saint Helena'),('SI','Slovenia'),('SJ','Svalbard and Jan Mayen'),('SK','Slovakia'),('SL','Sierra Leone'),('SM','San Marino'),('SN','Senegal'),('SO','Somalia'),('SR','Suriname'),('SS','South Sudan'),('ST','Sao Tome and Principe'),('SV','El Salvador'),('SX','Sint Maarten (Dutch part)'),('SY','Syrian Arab Republic'),('SZ','Swaziland'),('TC','Turks and Caicos Islands'),('TD','Chad'),('TF','French Southern Territories'),('TG','Togo'),('TH','Thailand'),('TJ','Tajikistan'),('TK','Tokelau'),('TL','Timor-Leste'),('TM','Turkmenistan'),('TN','Tunisia'),('TO','Tonga'),('TR','Turkey'),('TT','Trinidad and Tobago'),('TV','Tuvalu'),('TW','Taiwan'),('TZ','Tanzani'),('UA','Ukraine'),('UG','Uganda'),('UM','United States Minor Outlying Islands'),('US','United States'),('UY','Uruguay'),('UZ','Uzbekistan'),('VA','Holy See (Vatican City State)'),('VC','Saint Vincent and the Grenadines'),('VE','Venezuela'),('VG','Virgin Island'),('VI','Virgin Island'),('VN','Vietnam'),('VU','Vanuatu'),('WF','Wallis and Futuna'),('WS','Samoa'),('YE','Yemen'),('YT','Mayotte'),('ZA','South Africa'),('ZM','Zambia'),('ZW','Zimbabwe');
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametros`
--

DROP TABLE IF EXISTS `parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametros` (
  `IdParametro` int(11) NOT NULL AUTO_INCREMENT,
  `ISRParametro` decimal(10,2) NOT NULL,
  PRIMARY KEY (`IdParametro`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametros`
--

LOCK TABLES `parametros` WRITE;
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `parametros` VALUES (1,0.10);
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametrosplanilla`
--

DROP TABLE IF EXISTS `parametrosplanilla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametrosplanilla` (
  `IdParametroPlanilla` int(11) NOT NULL AUTO_INCREMENT,
  `FechaCreacion` varchar(45) NOT NULL,
  `MesPlanilla` varchar(45) NOT NULL,
  `PeriodoPlanilla` varchar(45) NOT NULL,
  `QuincenaPlanilla` varchar(45) NOT NULL,
  `FechaIni` varchar(45) NOT NULL,
  `FechaFin` varchar(45) NOT NULL,
  `Tipo` varchar(45) NOT NULL,
  PRIMARY KEY (`IdParametroPlanilla`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametrosplanilla`
--

LOCK TABLES `parametrosplanilla` WRITE;
/*!40000 ALTER TABLE `parametrosplanilla` DISABLE KEYS */;
INSERT INTO `parametrosplanilla` VALUES (26,'2018-09-18','Septiembre','2018','1','2018-09-01','2018-09-15','QUINCENAL');
/*!40000 ALTER TABLE `parametrosplanilla` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permiso`
--

DROP TABLE IF EXISTS `permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permiso` (
  `IdPermisos` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) DEFAULT NULL,
  `DiasPermiso` varchar(45) DEFAULT NULL,
  `SalarioDescuento` decimal(10,2) DEFAULT NULL,
  `FechaPermiso` date DEFAULT NULL,
  `PeriodoPermiso` varchar(45) DEFAULT NULL,
  `MesPermiso` varchar(45) DEFAULT NULL,
  `DescripcionPermiso` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`IdPermisos`),
  KEY `fk_permiso_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_permiso_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso`
--

LOCK TABLES `permiso` WRITE;
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planilla`
--

DROP TABLE IF EXISTS `planilla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planilla` (
  `IdPlanilla` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `Honorario` decimal(10,2) DEFAULT NULL,
  `Comision` decimal(10,2) DEFAULT NULL,
  `Bono` decimal(10,2) DEFAULT NULL,
  `Anticipos` decimal(10,2) DEFAULT NULL,
  `HorasExtras` decimal(10,2) DEFAULT NULL,
  `Vacaciones` decimal(10,2) DEFAULT NULL,
  `MesPlanilla` varchar(45) NOT NULL,
  `AnioPlanilla` varchar(45) NOT NULL,
  `FechaTransaccion` date NOT NULL,
  `ISRPlanilla` decimal(10,2) DEFAULT NULL,
  `AFPPlanilla` decimal(10,2) DEFAULT NULL,
  `ISSSPlanilla` decimal(10,2) DEFAULT NULL,
  `Incapacidades` decimal(10,2) DEFAULT NULL,
  `DiasIncapacidad` varchar(45) DEFAULT NULL,
  `Permisos` decimal(10,2) DEFAULT NULL,
  `DiasPermiso` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`IdPlanilla`),
  KEY `fk_planilla_empleado1` (`IdEmpleado`),
  CONSTRAINT `fk_planilla_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planilla`
--

LOCK TABLES `planilla` WRITE;
/*!40000 ALTER TABLE `planilla` DISABLE KEYS */;
/*!40000 ALTER TABLE `planilla` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propinas`
--

DROP TABLE IF EXISTS `propinas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `propinas` (
  `IdPropina` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `Fecha` varchar(45) NOT NULL,
  `PropinaPeriodo` varchar(45) NOT NULL,
  `PropinaMes` varchar(45) NOT NULL,
  `MontoPropina` decimal(10,2) NOT NULL,
  PRIMARY KEY (`IdPropina`),
  KEY `fk_propinal_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_propina_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propinas`
--

LOCK TABLES `propinas` WRITE;
/*!40000 ALTER TABLE `propinas` DISABLE KEYS */;
/*!40000 ALTER TABLE `propinas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puesto`
--

DROP TABLE IF EXISTS `puesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puesto` (
  `IdPuesto` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`IdPuesto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puesto`
--

LOCK TABLES `puesto` WRITE;
/*!40000 ALTER TABLE `puesto` DISABLE KEYS */;
INSERT INTO `puesto` VALUES (1,'Administrador'),(2,'Tecnico'),(4,'Gerente');
/*!40000 ALTER TABLE `puesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puestoempresa`
--

DROP TABLE IF EXISTS `puestoempresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puestoempresa` (
  `IdPuestoEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `IdDepartamentoEmpresa` int(11) DEFAULT NULL,
  `DescripcionPuestoEmpresa` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`IdPuestoEmpresa`),
  KEY `fk_puestoempresa_departamentoempresa1_idx` (`IdDepartamentoEmpresa`),
  CONSTRAINT `fk_puestoempresa_departamentoempresa1` FOREIGN KEY (`IdDepartamentoEmpresa`) REFERENCES `departamentoempresa` (`IdDepartamentoEmpresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puestoempresa`
--

LOCK TABLES `puestoempresa` WRITE;
/*!40000 ALTER TABLE `puestoempresa` DISABLE KEYS */;
INSERT INTO `puestoempresa` VALUES (1,4,'CONTADOR'),(2,4,'AUXILIAR CONTABLE'),(6,1,'GERENTE DE PROYECTOS'),(7,2,'MESERO'),(8,1,'GERENTE GENERAL'),(11,3,'TECNICO EN MANTENIMIENTO'),(12,6,'EJECUTIVO DE VENTAS'),(13,1,'JEFE DE HABITACIONES'),(14,1,'GERENTE DE ALIMENTOS'),(15,6,'MESERO'),(16,6,'CAPITAN MESEROS'),(17,1,'MUCAMA'),(18,7,'MUCAMA'),(19,7,'RECEPCION'),(20,8,'AUXILIAR DE COCINA'),(21,8,'COORDINDOR DE COCINA'),(22,8,'COORDINADOR DE COCINA'),(23,5,'EJECUTIVA DE VENTAS'),(24,5,'DISEÑO');
/*!40000 ALTER TABLE `puestoempresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puestomenu`
--

DROP TABLE IF EXISTS `puestomenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puestomenu` (
  `IdPuestoMenu` int(11) NOT NULL AUTO_INCREMENT,
  `IdPuesto` int(11) NOT NULL,
  `IdMenu` int(11) NOT NULL,
  PRIMARY KEY (`IdPuestoMenu`),
  KEY `fk_puestomenu_menu_idx` (`IdMenu`),
  KEY `fk_puestomenu_puesto_idx` (`IdPuesto`),
  CONSTRAINT `fk_puestomenu_menu1` FOREIGN KEY (`IdMenu`) REFERENCES `menu` (`IdMenu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_puestomenu_puesto1` FOREIGN KEY (`IdPuesto`) REFERENCES `puesto` (`IdPuesto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puestomenu`
--

LOCK TABLES `puestomenu` WRITE;
/*!40000 ALTER TABLE `puestomenu` DISABLE KEYS */;
/*!40000 ALTER TABLE `puestomenu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rptplanilla`
--

DROP TABLE IF EXISTS `rptplanilla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rptplanilla` (
  `IdRptPlanilla` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) DEFAULT NULL,
  `PRptSalario` decimal(10,2) DEFAULT NULL,
  `PRptExtras` decimal(10,2) DEFAULT NULL,
  `PRptTotal` decimal(10,2) DEFAULT NULL,
  `PRptIsss` decimal(10,2) DEFAULT NULL,
  `PRptAfp` decimal(10,2) DEFAULT NULL,
  `PRptIpsfa` decimal(10,2) DEFAULT NULL,
  `PRptRenta` decimal(10,2) DEFAULT NULL,
  `PRptPercepcion` decimal(10,2) DEFAULT NULL,
  `PRptAnticipo` decimal(10,2) DEFAULT NULL,
  `PRptLiquido` decimal(10,2) DEFAULT NULL,
  `RptPeriodo` varchar(45) DEFAULT NULL,
  `RptAnio` varchar(45) DEFAULT NULL,
  `RptQuincena` varchar(45) DEFAULT NULL,
  `PRrtSalarioNominal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`IdRptPlanilla`),
  KEY `fk_rptplanilla_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_rptplanilla_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rptplanilla`
--

LOCK TABLES `rptplanilla` WRITE;
/*!40000 ALTER TABLE `rptplanilla` DISABLE KEYS */;
/*!40000 ALTER TABLE `rptplanilla` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rptrentaanual`
--

DROP TABLE IF EXISTS `rptrentaanual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rptrentaanual` (
  `Idrptrentaanual` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(45) DEFAULT NULL,
  `IdEmpleado` int(11) DEFAULT NULL,
  `Nit` varchar(45) DEFAULT NULL,
  `CodigoIngreso` varchar(11) DEFAULT NULL,
  `MontoDevengado` decimal(10,2) DEFAULT NULL,
  `ImpuestoRetenido` decimal(10,2) DEFAULT NULL,
  `AguinaldoExento` decimal(10,2) DEFAULT NULL,
  `AguinaldoGravado` decimal(10,2) DEFAULT NULL,
  `Isss` decimal(10,2) DEFAULT NULL,
  `Afp` decimal(10,2) DEFAULT NULL,
  `Ipsfa` decimal(10,2) DEFAULT NULL,
  `BienestarMagisterial` decimal(10,2) DEFAULT NULL,
  `Anio` varchar(45) DEFAULT NULL,
  `Mes` varchar(45) DEFAULT NULL,
  `FechaCreacion` date DEFAULT NULL,
  `Quincena` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`Idrptrentaanual`),
  KEY `fk_rptrentaanual_empleado1_idx` (`IdEmpleado`),
  KEY `fk_rptrentaanual_codigoreporteanual1_idx` (`CodigoIngreso`),
  CONSTRAINT `fk_codigoreporteanuall_empleado1` FOREIGN KEY (`CodigoIngreso`) REFERENCES `codigoreporteanual` (`CodigoIngreso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rptrentaanual_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rptrentaanual`
--

LOCK TABLES `rptrentaanual` WRITE;
/*!40000 ALTER TABLE `rptrentaanual` DISABLE KEYS */;
/*!40000 ALTER TABLE `rptrentaanual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rptsepp`
--

DROP TABLE IF EXISTS `rptsepp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rptsepp` (
  `IdReporteSepp` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(13) DEFAULT NULL,
  `CodigoSepp` varchar(2) DEFAULT NULL,
  `PlanillaCodigoObservacion` varchar(45) DEFAULT NULL,
  `PlanillaIngresoBaseCotizacion` varchar(45) DEFAULT NULL,
  `PlanillaHorasJornadaLaboral` varchar(45) DEFAULT NULL,
  `PlanillaDiasCotizados` varchar(45) DEFAULT NULL,
  `PlanillaCotizacionVoluntariaAfiliado` varchar(45) DEFAULT NULL,
  `PlanillaCotizacionVoluntariaEmpleador` varchar(45) DEFAULT NULL,
  `Nup` varchar(45) DEFAULT NULL,
  `InstitucionPrevisional` varchar(45) DEFAULT NULL,
  `PrimerNombre` varchar(45) DEFAULT NULL,
  `SegundoNombre` varchar(45) DEFAULT NULL,
  `PrimerApellido` varchar(45) DEFAULT NULL,
  `SegundoApellido` varchar(45) DEFAULT NULL,
  `ApellidoCasada` varchar(45) DEFAULT NULL,
  `TipoDocumento` varchar(45) DEFAULT NULL,
  `NumeroDocumento` varchar(45) DEFAULT NULL,
  `Periodo` varchar(45) DEFAULT NULL,
  `Mes` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`IdReporteSepp`),
  KEY `fk_rptrentaanual_codigosepp1_idx_idx` (`CodigoSepp`),
  KEY `fk_rptseppl_codigosepp1_idx_idx` (`CodigoSepp`),
  CONSTRAINT `fk_rptsepp_codigosepp1_idx` FOREIGN KEY (`CodigoSepp`) REFERENCES `codigosepp` (`CodigoSepp`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rptsepp`
--

LOCK TABLES `rptsepp` WRITE;
/*!40000 ALTER TABLE `rptsepp` DISABLE KEYS */;
/*!40000 ALTER TABLE `rptsepp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipodocumento`
--

DROP TABLE IF EXISTS `tipodocumento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipodocumento` (
  `IdTipoDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `DescripcionTipoDocumento` varchar(45) NOT NULL,
  PRIMARY KEY (`IdTipoDocumento`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipodocumento`
--

LOCK TABLES `tipodocumento` WRITE;
/*!40000 ALTER TABLE `tipodocumento` DISABLE KEYS */;
INSERT INTO `tipodocumento` VALUES (1,'Carnet de Residente'),(2,'Pasaporte'),(3,'Carnet de Minoridad'),(4,'Documento Unico de Identidad');
/*!40000 ALTER TABLE `tipodocumento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoempleado`
--

DROP TABLE IF EXISTS `tipoempleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoempleado` (
  `IdTipoEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `DescipcionTipoEmpleado` varchar(45) NOT NULL,
  PRIMARY KEY (`IdTipoEmpleado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoempleado`
--

LOCK TABLES `tipoempleado` WRITE;
/*!40000 ALTER TABLE `tipoempleado` DISABLE KEYS */;
INSERT INTO `tipoempleado` VALUES (1,'Publico Administrativo'),(3,'Privado');
/*!40000 ALTER TABLE `tipoempleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tramoafp`
--

DROP TABLE IF EXISTS `tramoafp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tramoafp` (
  `IdTramoAfp` int(11) NOT NULL AUTO_INCREMENT,
  `TramoAfp` decimal(10,4) DEFAULT NULL,
  `TechoAfp` decimal(10,2) DEFAULT NULL,
  `TechoAfpSig` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`IdTramoAfp`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tramoafp`
--

LOCK TABLES `tramoafp` WRITE;
/*!40000 ALTER TABLE `tramoafp` DISABLE KEYS */;
INSERT INTO `tramoafp` VALUES (1,0.0725,6500.00,6500.01);
/*!40000 ALTER TABLE `tramoafp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tramoipsfa`
--

DROP TABLE IF EXISTS `tramoipsfa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tramoipsfa` (
  `IdTramoIpsfa` int(11) NOT NULL AUTO_INCREMENT,
  `TramoIpsfa` decimal(11,2) DEFAULT NULL,
  `TechoIpsfa` decimal(11,2) DEFAULT NULL,
  `TechoIpsfaSig` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`IdTramoIpsfa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tramoipsfa`
--

LOCK TABLES `tramoipsfa` WRITE;
/*!40000 ALTER TABLE `tramoipsfa` DISABLE KEYS */;
INSERT INTO `tramoipsfa` VALUES (1,0.06,2449.05,2449.06);
/*!40000 ALTER TABLE `tramoipsfa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tramoisr`
--

DROP TABLE IF EXISTS `tramoisr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tramoisr` (
  `IdTramoIsr` int(11) NOT NULL AUTO_INCREMENT,
  `NumTramo` varchar(45) DEFAULT NULL,
  `TramoDesde` decimal(10,2) DEFAULT NULL,
  `TramoHasta` decimal(10,2) DEFAULT NULL,
  `TramoAplicarPorcen` decimal(10,2) DEFAULT NULL,
  `TramoExceso` decimal(10,2) DEFAULT NULL,
  `TramoCuota` decimal(10,2) DEFAULT NULL,
  `TramoFormaPago` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`IdTramoIsr`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tramoisr`
--

LOCK TABLES `tramoisr` WRITE;
/*!40000 ALTER TABLE `tramoisr` DISABLE KEYS */;
INSERT INTO `tramoisr` VALUES (1,'Tramo 1',0.01,472.00,NULL,NULL,NULL,'MENSUAL'),(2,'Tramo 2',472.01,895.24,0.10,472.00,17.67,'MENSUAL'),(3,'Tramo 3',895.25,2038.10,0.20,895.24,60.00,'MENSUAL'),(4,'Tramo 4',2038.11,0.00,0.30,2038.10,288.57,'MENSUAL'),(5,'Tramo 1',0.01,236.00,NULL,NULL,NULL,'QUINCENAL'),(6,'Tramo 2',236.01,447.62,0.10,236.00,8.33,'QUINCENAL'),(7,'Tramo 3',447.63,1019.05,0.20,447.62,30.00,'QUINCENAL'),(8,'Tramo 4',1019.06,0.00,0.30,1019.05,144.28,'QUINCENAL'),(9,'Tramo 1',0.01,118.00,NULL,NULL,NULL,'SEMANAL'),(10,'Tramo 2',118.01,223.81,0.10,118.00,4.42,'SEMANAL'),(11,'Tramo 3',223.82,509.52,0.20,223.81,15.00,'SEMANAL'),(12,'Tramo 4',509.53,NULL,0.30,509.52,72.74,'SEMANAL');
/*!40000 ALTER TABLE `tramoisr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tramoisss`
--

DROP TABLE IF EXISTS `tramoisss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tramoisss` (
  `IdTramoIsss` int(11) NOT NULL AUTO_INCREMENT,
  `TramoIsss` decimal(10,2) DEFAULT NULL,
  `TechoIsss` decimal(10,2) DEFAULT NULL,
  `TechoSig` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`IdTramoIsss`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tramoisss`
--

LOCK TABLES `tramoisss` WRITE;
/*!40000 ALTER TABLE `tramoisss` DISABLE KEYS */;
INSERT INTO `tramoisss` VALUES (1,0.03,1000.00,1000.01);
/*!40000 ALTER TABLE `tramoisss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tramoupisss`
--

DROP TABLE IF EXISTS `tramoupisss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tramoupisss` (
  `IdTramoUpisss` int(11) NOT NULL AUTO_INCREMENT,
  `TramoUpisss` decimal(10,3) DEFAULT NULL,
  PRIMARY KEY (`IdTramoUpisss`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tramoupisss`
--

LOCK TABLES `tramoupisss` WRITE;
/*!40000 ALTER TABLE `tramoupisss` DISABLE KEYS */;
INSERT INTO `tramoupisss` VALUES (1,0.070);
/*!40000 ALTER TABLE `tramoupisss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `InicioSesion` varchar(50) DEFAULT NULL,
  `Nombres` varchar(100) DEFAULT NULL,
  `Apellidos` varchar(100) DEFAULT NULL,
  `Correo` varchar(100) DEFAULT NULL,
  `Clave` varchar(100) DEFAULT NULL,
  `Activo` int(11) DEFAULT NULL,
  `IdPuesto` int(11) DEFAULT NULL,
  `FechaIngreso` date DEFAULT NULL,
  `LexaAdmin` varchar(1) NOT NULL,
  `ImagenUsuario` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`IdUsuario`),
  KEY `fk_usuario_puesto1_idx` (`IdPuesto`),
  CONSTRAINT `fk_usuario_puesto1` FOREIGN KEY (`IdPuesto`) REFERENCES `puesto` (`IdPuesto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Lexasal','Soporte','Lexa','ulloa.nestor22@gmail.com','amigolexa',1,1,'2017-03-17','1','uploads/lexa.jpg'),(2,'Administrador','Administrador','Planilla','','admin123',1,1,'2017-07-04','0','uploads/admin.jpg');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuariopuesto`
--

DROP TABLE IF EXISTS `usuariopuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuariopuesto` (
  `IdUsuarioPuesto` int(11) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) NOT NULL,
  `IdPuesto` int(11) NOT NULL,
  PRIMARY KEY (`IdUsuarioPuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuariopuesto`
--

LOCK TABLES `usuariopuesto` WRITE;
/*!40000 ALTER TABLE `usuariopuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuariopuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacaciones`
--

DROP TABLE IF EXISTS `vacaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vacaciones` (
  `IdVacaciones` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) NOT NULL,
  `MesPeriodoVacaciones` varchar(15) NOT NULL,
  `AnoPeriodoVacaciones` varchar(15) NOT NULL,
  `MontoVacaciones` decimal(10,2) NOT NULL,
  `FechaVacaciones` date NOT NULL,
  PRIMARY KEY (`IdVacaciones`),
  KEY `fk_vacaciones_empleado1_idx` (`IdEmpleado`),
  CONSTRAINT `fk_vacaciones_empleado1` FOREIGN KEY (`IdEmpleado`) REFERENCES `empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacaciones`
--

LOCK TABLES `vacaciones` WRITE;
/*!40000 ALTER TABLE `vacaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `vacaciones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-04 11:58:16
