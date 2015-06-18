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

//Traigo los datos con el metodo POST para que no se vean en la barra URL
$nombre_usuario = @$_POST["nombre_usuario"];
$nombre = @$_POST["nombre"];
$clave = @$_POST["clave"]; 
$mail = @$_POST["mail"];
$fecha_nac = @$_POST["fecha_nac"];
$nivel = @$_POST["nivel"];
$activo = @$_POST["activo"];
$cmd = @$_POST["cmd"];

if( $cmd == "carga" ) {

//  abre la conexion
$conn_obj->open();
    
//Llamo el SP para agregar un alumno que tengo en la BD

    @$sql = "CALL agregar_usuario ('".$nombre_usuario."','".$nombre."','".$clave."','".$mail."','".$fecha_nac."',".$nivel.",".$activo.");";
    $res = mysql_query($sql);
    $rs = mysql_fetch_assoc($res);
    
    if ($rs["estado"] == "nuevo") {
        
        $cargado = "Se agrego un usuario nuevo: ".$rs["nombre"];
        
    } elseif ($rs["estado"] == "cargado") {
        $cargado = "Ya se encuentra registrado un usuario con el CUIL: ".$rs["nombre_usuario"];
    }

//  cierra la conexion
$conn_obj->close();

}
?>
