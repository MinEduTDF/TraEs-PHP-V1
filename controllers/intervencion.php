<?php
/**
 * @author Victoria Marino
 * @package controllers
 * @version 1.0
 */
//Con include_once llamamos a la p‡gina de referencia y la mostramos
include_once(dirname(__FILE__) . "/../includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Connection.php");

//  instancia los objetos
$conn_obj = new Connection();

//Traigo los datos con el mŽtdo POST para que no se vean en la barra URL
$dni = @$_POST["dni_alumno"];

// Datos para inscribirlo.
$titulo = @$_POST["titulo"];
$texto = @$_POST["texto"];
$fecha = @$_POST["fecha"];
$usuario = $_SESSION["id_usuario"];
$cmd = @$_POST["cmd"];

if( $cmd == "confirmar" ) {

    //  abre la conexion
    $conn_obj->open();
    
    //Llamo el SP para agregar un alumno que tengo en la BD
	$sql_ia ="CALL agregar_intervencion(".$dni.",'".$fecha."','".$usuario."','".$titulo."','".$texto."');";
	$res_ia = mysql_query($sql_ia);
    $rs_ia = mysql_fetch_assoc($res_ia);
    
    $intervencion = "Se agrego una intervencion";
    
    //  cierra la conexion
    $conn_obj->close();
}

?>
