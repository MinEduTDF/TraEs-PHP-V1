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


$id = @$_GET["id"];

//  instancia los objetos
$conn_obj = new Connection();
$fecha_f = new Date();

//  abre la conexion
$conn_obj->open();

$sql = "SELECT a.dni, a.apellido, a.nombre, la.fecha, 
	CASE
	    WHEN la.tipo_curso = 'R' THEN 'Curso Regular'
	    WHEN la.tipo_curso = 'T' THEN 'Curso Especializacion'
	    WHEN la.tipo_curso = 'E' THEN 'Curso Educacion Fisica'
	END as tipo_curso,
        CASE
            WHEN la.`estado` = 'A' THEN 'AUSENTE'
            WHEN la.`estado` = 'TC' THEN 'TARDE 1/4 FALTA'
            WHEN la.`estado` = 'TM' THEN 'TARDE 1/2 FALTA'
            WHEN la.`estado` = 'AP' THEN 'AUSENTE CON PERMANENCIA'
        END as estado, la.`justificado`, la.`observacion` FROM `lista_alumnos` la
        INNER JOIN `alumnos` a on a.dni = la.dni
        WHERE la.id = ".$id.";";
$res = mysql_query($sql);

$fecha_jus = @$_POST["fecha"];
$estado_jus = @$_POST["estado"];
$justificado_jus = (@$_POST["justificado"] == 1) ? 1 : 0;
$observacion_jus = @$_POST["observacion"];
$cmd_jus = @$_POST["cmd"];
$id_jus = @$_POST["id"];
$dni_jus = @$_POST["dni"];


if ($cmd_jus == "justificar"){

    //  abre la conexion
    $conn_obj->open();
    
    //Llamo el SP para agregar un alumno que tengo en la BD

    $sql_jus = "CALL justificar_inasistencia(".$id_jus.",".$justificado_jus.",'".$observacion_jus."','".$_SESSION["id_usuario"]."');";
    $res_jus = mysql_query($sql_jus);
    
        if (!$res_jus){
            
            $error = "No se pudo justificar la inasistencia. Comuniquese con el Administrador del Sistema :P !".$id_jus." | ".$justificado_jus." | ".$observacion_jus." | ".$_SESSION["nombre"];
            
        } else {
        
        header("location:asistencia_alumno.php?id=".$dni_jus);
        
        exit;
        }
        
    // cerrar la conexion
    $conn_obj->close();
}


?>
