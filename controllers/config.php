<?php
/**
 * @author Victoria Marino
 * @package controllers
 * @version 1.2
 */
//Con include_once llamamos a la p‡gina de referencia y la mostramos
include_once(dirname(__FILE__) . "/../includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/Classes/Connection.php");
include_once($APP_PATH . "/Classes/Date.php");

//  instancia los objetos
$conn_obj = new Connection();
$fecha = new Date();

//  abre la conexion
$conn_obj->open();

$sql_datos = "SELECT nombre, mail, fecha_nac FROM `usuarios` WHERE `nombre_usuario` = '".$_SESSION["id_usuario"]."';";
$res_datos = mysql_query($sql_datos);
$rs_datos = mysql_fetch_assoc($res_datos);
$nombre_datos = $rs_datos["nombre"];
$fecha_datos = $fecha ->sql2form($rs_datos["fecha_nac"]);
$mail_datos = $rs_datos["mail"];

//Traigo los datos con el mŽtdo POST para que no se vean en la barra URL
$clave_vieja = @$_POST["clave_vieja"];
$clave_nueva = @$_POST["clave_nueva"];
$cmd1 = @$_POST["cmd1"];

$nombre = @$_POST["nombre"];
$mail = @$_POST["mail"];
$fech_nac = @$fecha ->form2sql($_POST["fech_nac"]);
$cmd2 = @$_POST["cmd2"];

if( $cmd1 == "clave" ) {
    $sql_clave = "CALL cambiar_clave('".$_SESSION["id_usuario"]."','".$clave_vieja."','".$clave_nueva."');";
    $res_clave = mysql_query($sql_clave);
    if (!$res_clave){
        $error = "Ocurrio un error al querer cambiar sus datos por favor intente nuevamente o comuniquese con el Administrador del Sistema. Gracias! :P ";        
    } else {
        $rs_clave = mysql_fetch_assoc($res_clave);
        $estado = $rs_clave["estado"];
        if ( $estado == "si"){
            $error = "Se cambio la contrase&#241;a sin inconvenientes.";
        } else {
            $error = "<font color='#F6001C'>No se pudo cambiar la contrase&#241;a. Asegurese de estar poniendo bien su clave anterior.</font>";
        }
    }
}

if( $cmd2 == "datos" ) {
    $sql_cambiar = "UPDATE usuarios SET nombre = '".$nombre."', mail = '".$mail."', fecha_nac = '".$fech_nac."' WHERE nombre_usuario = '".$_SESSION["id_usuario"]."';";
    $res_cambiar = mysql_query($sql_cambiar);
    if (!$res_cambiar){
        $error = "Ocurrio un error al querer cambiar sus datos por favor intente nuevamente o comuniquese con el Administrador del Sistema. Gracias! :P ";        
    }
}

//  cierra la conexion
$conn_obj->close();

?>
