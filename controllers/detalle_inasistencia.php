<?php
/**
 * @author Victoria Marino
 * @package controllers
 * @version 2
 */
//Con include_once llamamos a la p‡gina de referencia y la mostramos
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/Classes/Connection.php");
include_once($APP_PATH . "/Classes/Date.php");

//  instancia los objetos
$conn_obj = new Connection();
$fecha_f = new Date();

$dni = @$_GET["id"];
$dia = @$_GET["dia"];
$mes = @$_GET["mes"];
$anio = @$_GET["anio"];

//  abre la conexion
$conn_obj->open();

$sql = "SELECT a.apellido, a.nombre, la.fecha, la.`id`, tc.descripcion as tipo_curso,
        CASE
            WHEN la.`estado` = 'A' THEN 'AUSENTE'
            WHEN la.`estado` = 'TC' THEN 'TARDE 1/4 FALTA'
            WHEN la.`estado` = 'TM' THEN 'TARDE 1/2 FALTA'
            WHEN la.`estado` = 'AP' THEN 'AUSENTE CON PERMANENCIA'
        END as estado, la.`justificado`, la.`observacion` FROM `lista_alumnos` la
        INNER JOIN `alumnos` a on a.dni = la.dni
        INNER JOIN `tipo_curso` tc on tc.id_tipocurso = la.tipo_curso
        WHERE la.dni = '".$dni."'
        AND extract(DAY FROM la.fecha)= ".$dia."
        AND extract(MONTH FROM la.fecha)= ".$mes."
        AND extract(YEAR FROM la.fecha)= ".$anio."
        AND la.`estado` <> 'P';";
$res = mysql_query($sql);


?>
