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
include_once($APP_PATH . "/Classes/Date.php");

//  instancia los objetos
$conn_obj = new Connection();
$fecha = new Date();

//Traigo los datos con el mŽtdo POST para que no se vean en la barra URL
$titulo = @$_POST["titulo"];
$texto = @$_POST["texto"];
$fecha_desde = @$fecha ->form2sql($_POST["fecha_desde"]);
$fecha_hasta = @$fecha ->form2sql($_POST["fecha_hasta"]);
$cmd = @$_POST["cmd"];
$usuario = $_SESSION["id_usuario"];
$fecha = date("Ymd");

if( $cmd == "novedad" ) {

//  abre la conexion
$conn_obj->open();

    @$sql = "INSERT INTO `novedades`
            (titulo, texto, fecha_desde, fecha_hasta, usuario, fecha)
            VALUES ('".$titulo."','".$texto."','".$fecha_desde."','".$fecha_hasta."','".$usuario."','".$fecha."');";
    $res = mysql_query($sql);
    
    if (!$res){
        
        $error = "Ocurrio un error al cargar la Novedad por favor intente nuevamente o comuniquese con el Administrador del Sistema. Gracias! :P ";        
        
    }

//  cierra la conexion
$conn_obj->close();


}

?>