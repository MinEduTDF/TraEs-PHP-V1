# ************************************************************
# Sequel Pro SQL dump
# Versión 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.6.14)
# Base de datos: traes
# Tiempo de Generación: 2014-08-26 13:42:17 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla alumnos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `alumnos`;

CREATE TABLE `alumnos` (
  `dni` int(8) unsigned NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `genero` varchar(1) DEFAULT NULL,
  `lugar_nac` int(11) DEFAULT NULL,
  `nacionalidad` int(11) DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `domicilio` varchar(255) DEFAULT NULL,
  `telefono` varchar(100) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `id_alumno_curso` int(11) DEFAULT NULL,
  `id_alumno_taller` int(11) DEFAULT NULL,
  `id_alumno_edfisica` int(11) DEFAULT NULL,
  `auto_medico` tinyint(1) DEFAULT NULL,
  `auto_salida` tinyint(1) DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `id_primaria` int(11) DEFAULT NULL,
  `id_secundario` int(11) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla alumnos_cursos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `alumnos_cursos`;

CREATE TABLE `alumnos_cursos` (
  `id_alumno_curso` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dni` int(8) DEFAULT NULL,
  `id_turno` varchar(1) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `id_division` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `usuario` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_alumno_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `alumnos_cursos` WRITE;
/*!40000 ALTER TABLE `alumnos_cursos` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnos_cursos` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla alumnos_edfisica
# ------------------------------------------------------------

DROP TABLE IF EXISTS `alumnos_edfisica`;

CREATE TABLE `alumnos_edfisica` (
  `id_alumno_edfisica` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dni` int(8) DEFAULT NULL,
  `id_edfisica` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `usuario` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_alumno_edfisica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla alumnos_talleres
# ------------------------------------------------------------

DROP TABLE IF EXISTS `alumnos_talleres`;

CREATE TABLE `alumnos_talleres` (
  `id_alumno_taller` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dni` int(8) DEFAULT NULL,
  `id_taller` int(11) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `id_division` int(11) DEFAULT NULL,
  `id_especializacion` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `usuario` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_alumno_taller`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla cursos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cursos`;

CREATE TABLE `cursos` (
  `id_curso` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  `turno` varchar(1) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `cursos` WRITE;
/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;

INSERT INTO `cursos` (`id_curso`, `descripcion`, `turno`, `activo`)
VALUES
	(1,'1ero. ESO','',0),
	(2,'2do. ESO','',0),
	(3,'3ero. ESO','',0),
	(4,'1ero. POLIMODAL','',1),
	(5,'2do. POLIMODAL','',0),
	(6,'3ero. POLIMODAL','',0),
	(7,'9no. EGB','',1),
	(8,'4to. ESO','',0),
	(9,'5to. ESO','',1),
	(10,'6to. ESO','',1);

/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla divisiones
# ------------------------------------------------------------

DROP TABLE IF EXISTS `divisiones`;

CREATE TABLE `divisiones` (
  `id_division` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_division`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `divisiones` WRITE;
/*!40000 ALTER TABLE `divisiones` DISABLE KEYS */;

INSERT INTO `divisiones` (`id_division`, `descripcion`, `activo`)
VALUES
	(1,'1ero.',0),
	(2,'2da.',0),
	(3,'3era.',0),
	(4,'4ta.',0),
	(5,'5ta.',0),
	(6,'A',0),
	(7,'B',0),
	(8,'C',0),
	(9,'D',0),
	(10,'E',0);

/*!40000 ALTER TABLE `divisiones` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla educacion_fisica
# ------------------------------------------------------------

DROP TABLE IF EXISTS `educacion_fisica`;

CREATE TABLE `educacion_fisica` (
  `id_edfisica` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  `genero` varchar(1) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_edfisica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla especializaciones
# ------------------------------------------------------------

DROP TABLE IF EXISTS `especializaciones`;

CREATE TABLE `especializaciones` (
  `id_especializacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `id_taller` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_especializacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla intervencion_cabecera
# ------------------------------------------------------------

DROP TABLE IF EXISTS `intervencion_cabecera`;

CREATE TABLE `intervencion_cabecera` (
  `id_intervencion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `usuario` varchar(11) DEFAULT NULL,
  `titulo` varchar(60) DEFAULT NULL,
  `dni_alumno` int(8) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_intervencion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla intervencion_cuerpo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `intervencion_cuerpo`;

CREATE TABLE `intervencion_cuerpo` (
  `id_intervencion` int(11) unsigned NOT NULL,
  `texto` longtext,
  PRIMARY KEY (`id_intervencion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla lista_alumnos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lista_alumnos`;

CREATE TABLE `lista_alumnos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `tipo_curso` varchar(1) NOT NULL,
  `dni` int(8) NOT NULL,
  `estado` varchar(2) NOT NULL DEFAULT '',
  `justificado` tinyint(1) DEFAULT NULL,
  `curso` int(11) NOT NULL DEFAULT '0',
  `division` int(11) NOT NULL DEFAULT '0',
  `taller` int(11) NOT NULL DEFAULT '0',
  `especializacion` int(11) NOT NULL DEFAULT '0',
  `edfisica` int(11) NOT NULL DEFAULT '0',
  `observacion` varchar(200) DEFAULT NULL,
  `usuario` varchar(11) NOT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla lista_cursos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lista_cursos`;

CREATE TABLE `lista_cursos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `tipo_curso` varchar(1) NOT NULL,
  `curso` int(11) NOT NULL,
  `division` int(11) NOT NULL,
  `taller` int(11) NOT NULL,
  `edfisica` int(11) NOT NULL DEFAULT '0',
  `usuario` varchar(11) NOT NULL,
  `fecha_carga` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla lugar_nacimiento
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lugar_nacimiento`;

CREATE TABLE `lugar_nacimiento` (
  `id_lugarnacimiento` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id_lugarnacimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `lugar_nacimiento` WRITE;
/*!40000 ALTER TABLE `lugar_nacimiento` DISABLE KEYS */;

INSERT INTO `lugar_nacimiento` (`id_lugarnacimiento`, `descripcion`)
VALUES
	(1,'Buenos Aires'),
	(2,'Capital Federal'),
	(3,'Catamarca'),
	(4,'Chaco'),
	(5,'Chubut'),
	(6,'Córdoba'),
	(7,'Corrientes'),
	(8,'Entre Ríos'),
	(9,'Formosa'),
	(10,'Jujuy'),
	(11,'La Pampa'),
	(12,'La Rioja'),
	(13,'Mendoza'),
	(14,'Misiones'),
	(15,'Neuquén'),
	(16,'Río Negro'),
	(17,'Salta'),
	(18,'San Juan'),
	(19,'San Luis'),
	(20,'Santa Cruz'),
	(21,'Santa Fe'),
	(22,'Santiago del Estero'),
	(23,'Tierra del Fuego'),
	(24,'Tucumán'),
	(25,'Otro');

/*!40000 ALTER TABLE `lugar_nacimiento` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla nacionalidad
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nacionalidad`;

CREATE TABLE `nacionalidad` (
  `id_nacionalidad` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_nacionalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `nacionalidad` WRITE;
/*!40000 ALTER TABLE `nacionalidad` DISABLE KEYS */;

INSERT INTO `nacionalidad` (`id_nacionalidad`, `descripcion`)
VALUES
	(1,'Argentina'),
	(2,'Uruguay'),
	(3,'Paraguay'),
	(4,'Chile'),
	(5,'Bolivia'),
	(6,'Brasil');

/*!40000 ALTER TABLE `nacionalidad` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla novedades
# ------------------------------------------------------------

DROP TABLE IF EXISTS `novedades`;

CREATE TABLE `novedades` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `texto` varchar(200) DEFAULT NULL,
  `fecha_desde` date DEFAULT NULL,
  `fecha_hasta` date DEFAULT NULL,
  `usuario` varchar(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla primarias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `primarias`;

CREATE TABLE `primarias` (
  `id_primaria` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) DEFAULT '',
  `localidad` varchar(20) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_primaria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `primarias` WRITE;
/*!40000 ALTER TABLE `primarias` DISABLE KEYS */;

INSERT INTO `primarias` (`id_primaria`, `descripcion`, `localidad`, `activo`)
VALUES
	(1,'Escuela Nº 1 - Domingo Faustino Sarmiento ','Ushuaia',0),
	(2,'Escuela Nº 3 - Monseñor Fagnano ','Ushuaia',0),
	(3,'Escuela Nº 9 - Cdte. Luis Piedra Buena','Ushuaia',0),
	(4,'Escuela Nº 13 - Almirante Guillermo Brown ','Ushuaia',0),
	(5,'Escuela Nº 15 - Centenario de Ushuaia','Ushuaia',0),
	(6,'Escuela Nº 16 - Dr. Arturo Mateo Bas ','Ushuaia',0),
	(7,'Escuela Nº 22 - Bahía Golondrina','Ushuaia',0),
	(8,'Escuela Nº 24 - Juan Ruiz Galán ','Ushuaia',0),
	(9,'Escuela Nº 30 - Oshovia ','Ushuaia',0),
	(10,'Escuela Nº 31 - Juana Manso ','Ushuaia',0),
	(11,'Escuela Nº 34 - Yak-Haruin','Ushuaia',0),
	(12,'Escuela Nº 39 - Mirador del Olivia','Ushuaia',0),
	(13,'Escuela Nº 40 - Los Coihues','Ushuaia',0),
	(14,'Escuela Nº 41 - Mario Benedetti','Ushuaia',0),
	(15,'Escuela Experimental - Los Calafates','Ushuaia',0),
	(16,'Escuela Experimental - Las Gaviotas','Ushuaia',0),
	(17,'Escuela Experimental - La Bahía ','Ushuaia',0),
	(18,'Escuela Experimental - Los Alakalufes','Ushuaia',0),
	(19,'Escuela Experimental - Las Lengas','Ushuaia',0),
	(20,'Escuela Especial Nº 1 - Kayú Chénén ','Ushuaia',0),
	(21,'Colegio Don Bosco - Ushuaia','Ushuaia',0),
	(22,'Colegio del Sur','Ushuaia',0),
	(23,'Colegio Nacional Ushuaia','Ushuaia',0),
	(24,'Escuela EGB Julio Verne','Ushuaia',0),
	(25,'Escuela Modelo de Educación Integral - EMEI','Ushuaia',0),
	(26,'Otro','Ushuaia',0);

/*!40000 ALTER TABLE `primarias` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla secundarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `secundarios`;

CREATE TABLE `secundarios` (
  `id_secundario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) DEFAULT NULL,
  `localidad` varchar(20) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_secundario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `secundarios` WRITE;
/*!40000 ALTER TABLE `secundarios` DISABLE KEYS */;

INSERT INTO `secundarios` (`id_secundario`, `descripcion`, `localidad`, `activo`)
VALUES
	(1,'Colegio José Martí ','Ushuaia',0),
	(2,'Colegio Técnico Olga B. de Arko ','Ushuaia',0),
	(3,'Centro Polivalente de Arte de Ushuaia','Ushuaia',0),
	(4,'Colegio Dr. José María Sobral ','Ushuaia',0),
	(5,'Colegio Los Andes ','Ushuaia',1),
	(6,'Colegio Ernesto Sábato','Ushuaia',0),
	(7,'Colegio Kloketén ','Ushuaia',0),
	(8,'Colegio Kloketén - Edif. Enriqueta Gastelumendi','Ushuaia',0),
	(9,'Instituto Salesiano Don Bosco','Ushuaia',0),
	(10,'Colegio Monseñor Miguel Angel Alemán','Ushuaia',0),
	(11,'Colegio Nacional Ushuaia','Ushuaia',0),
	(12,'C.I.E.U. Lib. Gral. San Martín','Ushuaia',0),
	(13,'Escuela Modelo de Educación Integral - EMEI','Ushuaia',0),
	(14,'Colegio Ramón Alberto Trejo Noel','Tolhuin',0),
	(15,'Colegio Antártida Argentina ','Rio Grande',0),
	(16,'Colegio Comandante Luis Piedrabuena ','Rio Grande',0),
	(17,'Colegio Soberanía Nacional ','Rio Grande',0),
	(18,'Colegio Alicia Moreau de Justo ','Rio Grande',0),
	(19,'Colegio de Educación Tecnológica Río Grande ','Rio Grande',0),
	(20,'Centro Polivalente de Arte de Rio Grande','Rio Grande',0),
	(21,'Colegio Haspen ','Rio Grande',0),
	(22,'Colegio Dr. Ernesto Guevara ','Rio Grande',0),
	(23,'Colegio Dr. Esteban Laureano Maradona ','Rio Grande',0),
	(24,'Colegio Dr. René Favaloro ','Rio Grande',0),
	(25,'Instituto Salesiano Don Bosco - Rio Grande','Rio Grande',0),
	(26,'Instituto María Auxiliadora','Rio Grande',0),
	(27,'Esc. Agrotécnica Salesiana','Rio Grande',0),
	(28,'Colegio Integral de Educación Rio Grande','Rio Grande',0),
	(29,'EMEI - Rio Grande','Rio Grande',0),
	(30,'J.I.F. Juvenil Instituto Fueguino','Rio Grande',0),
	(31,'Esc. Privada de Educación Integral Marina','Rio Grande',0),
	(32,'Instituto República Argentina','Rio Grande',0),
	(33,'I.S.E.S.','Rio Grande',0),
	(34,'Ninguno',NULL,0);

/*!40000 ALTER TABLE `secundarios` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla talleres
# ------------------------------------------------------------

DROP TABLE IF EXISTS `talleres`;

CREATE TABLE `talleres` (
  `id_taller` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_taller`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla turnos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `turnos`;

CREATE TABLE `turnos` (
  `id_turno` varchar(1) NOT NULL DEFAULT '',
  `descripcion` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_turno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `turnos` WRITE;
/*!40000 ALTER TABLE `turnos` DISABLE KEYS */;

INSERT INTO `turnos` (`id_turno`, `descripcion`, `activo`)
VALUES
	('M','Mañana',0),
	('T','Tarde',0),
	('V','Vespertino',0);

/*!40000 ALTER TABLE `turnos` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla usuarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id_usuario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(11) NOT NULL DEFAULT '',
  `nombre` varchar(60) NOT NULL DEFAULT '',
  `clave` varchar(8) NOT NULL DEFAULT '',
  `mail` varchar(60) DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `nombre`, `clave`, `mail`, `fecha_nac`, `nivel`, `activo`)
VALUES
	(1,'1234','Administrador','prometeo','marino.educaciontdf@gmail.com',NULL,9,0),
	(2,'27296523041','Victoria','1234',NULL,NULL,1,0);

/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Dumping routines (PROCEDURE) for database 'traes'
--
DELIMITER ;;

# Dump of PROCEDURE agregar_alumno
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `agregar_alumno` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `agregar_alumno`(IN `f_nombre` VARCHAR(60), IN `f_apellido` VARCHAR(60), IN `f_alias` VARCHAR(50), IN `f_dni` INT, IN `f_lugarnac` INT, IN `f_nacionalidad` INT, IN `f_fecha_nac` DATETIME, IN `f_domicilio` VARCHAR(100), IN `f_telefono` VARCHAR(60), IN `f_mail` VARCHAR(100), IN `f_genero` VARCHAR(1), IN `f_observacion` TEXT, IN `f_foto` VARCHAR(255), IN `f_activo` TINYINT, IN `f_primaria` INT, IN `f_secundario` INT, IN `f_medico` TINYINT, IN `f_salida` TINYINT)
BEGIN


IF (SELECT `dni` FROM `alumnos` WHERE `dni` = f_dni) IS NULL THEN
	INSERT INTO `alumnos` (`dni`, `apellido`, `nombre`, `alias`, `genero`, `lugar_nac`, `nacionalidad`, `fecha_nac`, `domicilio`, `telefono`, `mail`, `auto_medico`, `auto_salida`, `observacion`, `id_primaria`, `id_secundario`, `foto`, `activo`)
	VALUES (f_dni, f_apellido, f_nombre, f_alias, f_genero, f_lugarnac, f_nacionalidad, f_fecha_nac, f_domicilio, f_telefono, f_mail, f_medico, f_salida, f_observacion, f_primaria, f_secundario, f_foto, f_activo);
	SELECT a.`nombre` AS nombre_alumno, a.`apellido`, a.`dni`, 'nuevo' AS estado FROM alumnos a 
	WHERE a.`dni` = f_dni;

ELSE
	SELECT a.`nombre` AS nombre_alumno, a.`apellido`, a.`dni`, 'cargado' AS estado FROM alumnos a 
	WHERE a.`dni` = f_dni;
	

END IF;


END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE agregar_intervencion
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `agregar_intervencion` */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `agregar_intervencion`(`f_alumno` int, `f_fecha` DATETIME, `f_usuario` VARCHAR(11), `f_titulo` VARCHAR(60), `f_texto` LONGTEXT)
BEGIN

	INSERT INTO `intervencion_cabecera` (`fecha`, `usuario`, `titulo`, `dni_alumno`)
	VALUES (f_fecha, f_usuario, f_titulo, f_alumno);

	
	INSERT INTO `intervencion_cuerpo` (`id_intervencion`, `texto`)
	VALUES ((SELECT max(`id_intervencion`) FROM `intervencion_cabecera`), f_texto);

END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE agregar_usuario
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `agregar_usuario` */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `agregar_usuario`(f_usuario varchar(11), f_nombre varchar(60), f_clave varchar(8), f_mail varchar(60), f_fecha_nac DATE, f_nivel int, f_activo tinyint)
BEGIN 
IF (SELECT nombre_usuario FROM usuarios WHERE nombre_usuario = f_usuario) IS NULL THEN
    INSERT INTO usuarios (nombre_usuario, nombre, clave, mail, fecha_nac, nivel, activo)
    VALUES (f_usuario, f_nombre, f_clave, f_mail, f_fecha_nac, f_nivel, f_activo);

    SELECT u.nombre_usuario, u.nombre, 'nuevo' AS estado FROM usuarios WHERE nombre_usuario = f_usuario;

ELSE

    SELECT u.nombre_usuario, u.nombre, 'cargado' AS estado FROM usuarios WHERE nombre_usuario = f_usuario;

END IF;

END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE buscar_alumno
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `buscar_alumno` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `buscar_alumno`(apellido_bus VARCHAR(60), dni_bus INTEGER)
BEGIN

IF dni_bus = 0 THEN 

SELECT a.`apellido`, a.`nombre`, a.`dni`, a.`foto`, t.`descripcion` AS turno, c.`descripcion` AS curso, d.`descripcion` AS division
FROM `alumnos` a
LEFT OUTER JOIN `alumnos_cursos` ac ON ac.`id_alumno_curso` = a.`id_alumno_curso`
LEFT OUTER JOIN `turnos` t ON t.`id_turno` = ac.`id_turno`
LEFT OUTER JOIN `cursos` c ON c.`id_curso` = ac.`id_curso`
LEFT OUTER JOIN `divisiones` d ON d.`id_division` = ac.`id_division`
WHERE a.`apellido` LIKE apellido_bus 
AND a.`activo` = 0
ORDER BY a.`apellido`, t.`id_turno`, c.`id_curso`, d.`id_division`;

ELSE

SELECT a.`apellido`, a.`nombre`, a.`dni`, a.`foto`, t.`descripcion` AS turno, c.`descripcion` AS curso, d.`descripcion` AS division
FROM `alumnos` a
LEFT OUTER JOIN `alumnos_cursos` ac ON ac.`id_alumno_curso` = a.`id_alumno_curso`
LEFT OUTER JOIN `turnos` t ON t.`id_turno` = ac.`id_turno`
LEFT OUTER JOIN `cursos` c ON c.`id_curso` = ac.`id_curso`
LEFT OUTER JOIN `divisiones` d ON d.`id_division` = ac.`id_division`
WHERE a.`dni` = dni_bus
AND a.`activo` = 0
ORDER BY a.`apellido`, t.`id_turno`, c.`id_curso`, d.`id_division`;

END IF; 
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE cambiar_clave
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `cambiar_clave` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `cambiar_clave`(usuario VARCHAR(11), clave_vieja VARCHAR(8), clave_nueva VARCHAR(8))
BEGIN

IF (SELECT activo FROM usuarios u WHERE u.`nombre_usuario` = usuario AND u.`clave` = clave_vieja) = 0 THEN
	UPDATE usuarios SET `clave` = clave_nueva WHERE `nombre_usuario` = usuario;
	SELECT "si" AS estado;

ELSE
	SELECT "no" AS estado;

END IF;

 	
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE inscribir_curso
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `inscribir_curso` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `inscribir_curso`(dni_bus INTEGER, turno_bus VARCHAR(1), curso_bus INTEGER, division_bus INTEGER, fecha_bus DATE, usuario_bus VARCHAR(11))
BEGIN

	INSERT INTO `alumnos_cursos` (`dni`, `id_turno`, `id_curso`, `id_division`, `fecha`, `usuario`)
	VALUES (dni_bus, turno_bus, curso_bus, division_bus, fecha_bus, usuario_bus);
	
	UPDATE `alumnos` 
	SET `id_alumno_curso` = (SELECT `id_alumno_curso` FROM `alumnos_cursos` WHERE `dni`=dni_bus AND `id_turno`=turno_bus AND `id_curso`=curso_bus AND `id_division`=division_bus AND `fecha`=fecha_bus AND `usuario`=usuario_bus)
	WHERE `dni` = dni_bus;
	
	SELECT ac.`id_alumno_curso`, t.`descripcion` AS turno, c.`descripcion` AS curso, d.`descripcion` AS division, ac.`fecha`, u.`nombre` AS usuario
	FROM `alumnos_cursos` ac
	INNER JOIN `turnos` t ON t.`id_turno` = ac.`id_turno`
	INNER JOIN `cursos` c ON c.`id_curso` = ac.`id_curso`
	INNER JOIN `divisiones` d ON d.`id_division` = ac.`id_division`
	INNER JOIN `usuarios` u ON u.`nombre_usuario` = ac.`usuario`
	WHERE ac.`dni` = dni_bus AND ac.`id_turno`=turno_bus AND ac.`id_curso`=curso_bus AND ac.`id_division`=division_bus AND ac.`fecha`=fecha_bus AND ac.`usuario`=usuario_bus;
	
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE justificar_inasistencia
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `justificar_inasistencia` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `justificar_inasistencia`(f_id INT, f_jus TINYINT, f_obs VARCHAR(200), f_usuario VARCHAR(11))
BEGIN

UPDATE `lista_alumnos` 
SET 
`justificado` = f_jus,
`observacion` = f_obs,
`usuario` = f_usuario
WHERE `id` = f_id;

END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE llegada_tarde
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `llegada_tarde` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `llegada_tarde`(f_id INT, f_estado VARCHAR(2), f_jus TINYINT, f_obs VARCHAR(200), f_usuario VARCHAR(11))
BEGIN

UPDATE `lista_alumnos` 
SET `estado` = f_estado,
`justificado` = f_jus,
`observacion` = f_obs,
`usuario` = f_usuario
WHERE `id` = f_id;

END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE novedad_alumno
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `novedad_alumno` */;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `novedad_alumno`(dni_bus INTEGER, turno_bus VARCHAR(1), curso_bus INTEGER, division_bus INTEGER, fecha_bus DATE, usuario_bus VARCHAR(11), estado_bus varchar(1))
BEGIN
IF estado_bus = "P" THEN
	INSERT INTO `alumnos_cursos` (`dni`, `id_turno`, `id_curso`, `id_division`, `fecha`, `usuario`)
	VALUES (dni_bus, turno_bus, curso_bus, division_bus, fecha_bus, usuario_bus);
	
	UPDATE `alumnos` 
	SET `id_alumno_curso` = (SELECT `id_alumno_curso` FROM `alumnos_cursos` WHERE `dni`=dni_bus AND `id_turno`=turno_bus AND `id_curso`=curso_bus AND `id_division`=division_bus AND `fecha`=fecha_bus AND `usuario`=usuario_bus)
	WHERE `dni` = dni_bus;
ELSEIF estado_bus = "E" THEN
	UPDATE `alumnos`
	SET `id_alumno_curso` = 0,
	`activo` = 1
	WHERE `dni` = dni_bus;
ELSEIF estado_bus = "C" THEN
	UPDATE `alumnos`
	SET `id_alumno_curso` = 0,
	`activo` = 2
	WHERE `dni` = dni_bus;
ELSEIF estado_bus = "A" THEN
	UPDATE `alumnos`
	SET `id_alumno_curso` = 0,
	`activo` = 3
	WHERE `dni` = dni_bus;
ELSEIF estado_bus = "O" THEN
	UPDATE `alumnos`
	SET `id_alumno_curso` = 0,
	`activo` = 4
	WHERE `dni` = dni_bus;
END	IF;

END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE validar_usuario
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `validar_usuario` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `validar_usuario`(usuario VARCHAR(11), clave VARCHAR(8), flag INTEGER)
BEGIN

IF (SELECT activo FROM usuarios u WHERE u.`nombre_usuario` = usuario AND u.`clave` = clave) = 0 THEN
	SET flag = 1;
ELSEIF (SELECT activo FROM usuarios u WHERE u.`nombre_usuario` = usuario AND u.`clave` = clave) = 1 THEN
	SET flag = 0;
ELSE
	SET flag = 0;
END IF;

SELECT u.nombre, u.nombre_usuario, u.mail, u.nivel, flag FROM usuarios u WHERE `nombre_usuario` = usuario AND `clave` = clave;
 	
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
DELIMITER ;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;