<?php
/**
 * @author Victoria Marino
 * @package controllers
 * @version 1
 */
//Con include_once llamamos a la p‡gina de referencia y la mostramos
include_once(dirname(__FILE__) . "/../includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Connection.php");
include_once($APP_PATH . "/Classes/Date.php");

//  instancia los objetos
$conn_obj = new Connection();
$fecha = new Date();

//Traigo los datos con el mŽtdo POST para que no se vean en la barra URL
$cmd = @$_POST["cmd"];
$ids = @$_POST['ids'];
$fec = $fecha ->form2sql(@$_POST["fecha"]);
$taller_alumno = @$_POST["taller"];
$curso_alumno = @$_POST["curso"];
$division_alumno = @$_POST["division"];
$tipo_curso_a = @$_POST["tipo_curso"];
$curso_sig = $curso_alumno + 1;

if( $cmd == "confirmar" ) {
//  abre la conexion
$conn_obj->open();

if ($tipo_curso_a == "R") {

	if (sizeof($ids) > 0) {
	
        foreach($ids as $id) {
        	$i=$i+1;
			$sql_p ="CALL novedad_alumno(".$id.",'',".$curso_sig.",0,'".$fec."','".$_SESSION["id_usuario"]."','".@$_POST[$i]."');";
			$res_p = mysql_query($sql_p);
			} 
        }
        header("location:novedad_curso.php");
        exit;
}

//  cierra la conexion
$conn_obj->close();

}

?>
