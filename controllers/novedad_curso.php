<?php
/**
 * @author Victoria Marino
 * @package controllers
 * @version 1.0
 */
//Con include_once llamamos a la pgina de referencia y la mostramos
include_once(dirname(__FILE__) . "/../includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Connection.php");
include_once($APP_PATH . "/Classes/Date.php");

$activo = 0;

//  instancia los objetos
$conn_obj = new Connection();

$cmd = @$_POST["cmd"];

if( $cmd == "buscar" ) {
	$activo = 1;
	$tipo_curso = @$_POST["tipo_curso"];

}

?>
