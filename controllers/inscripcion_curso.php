<?php
/**
 * @author Victoria Marino
 * @package controllers
 * @version 1.2
 */
//Con include_once llamamos a la p‡gina de referencia y la mostramos
include_once(dirname(__FILE__) . "/../includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Connection.php");

//  instancia los objetos
$conn_obj = new Connection();

//Traigo los datos con el mŽtdo POST para que no se vean en la barra URL
$dni_inscripcion = @$_POST["dni_alumno"];

// Datos para inscribirlo.
$tipocurso_inscripcion = @$_POST["tipocurso"];
$curso_inscripcion = @$_POST["curso"];
$division_inscripcion = @$_POST["division"];
$fecha_inscripcion = @$_POST["fecha"];
$usuario_inscripcion = $_SESSION["id_usuario"];
$cmd = @$_POST["cmd"];

if( $cmd == "confirmar" ) {

    //  abre la conexion
    $conn_obj->open();
    
    //Llamo el SP para agregar un alumno que tengo en la BD
	$sql_ia ="CALL inscribir_cursos(".$dni_inscripcion.",".$tipocurso_inscripcion.",".$curso_inscripcion.",".$division_inscripcion.",'".$fecha_inscripcion."','".$usuario_inscripcion."');";
	$res_ia = mysql_query($sql_ia);
    $rs_ia = mysql_fetch_assoc($res_ia);
    
	if ($rs_ia["estado"]=="nuevo"){
		$inscripto = "Se inscribi&oacute; al alumno en ".$rs_ia["tipocurso"]." | ".$rs_ia["curso"]." | ".$rs_ia["division"];
    } elseif ($rs_ia["estado"]=="cargado"){
		$inscripto = "El alumno ya esta inscripto en ".$rs_ia["tipocurso"]." | ".$rs_ia["curso"]." | ".$rs_ia["division"]."<strong>. Debe darlo de baja antes de cambiarlo de curso</strong>";
	}
    //  cierra la conexion
    $conn_obj->close();
}

?>
