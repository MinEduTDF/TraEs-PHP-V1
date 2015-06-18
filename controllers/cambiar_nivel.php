<?php
/**
 * @author Victoria Marino
 * @package controllers
 * @version 1
 */
//Con include_once llamamos a la pgina de referencia y la mostramos
include_once(dirname(__FILE__) . "/../includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/Classes/Connection.php");

/*Recibo el id del usuario */
$usuario = $_GET["id"];

//  instancia los objetos
$conn_obj = new Connection();
$conn_obj->open();

if ($usuario == 0) {
    echo "No tiene seleccionado ning&uacute;n usuario";

} else {

//Consulta de datos resumidos del usuario
    $sql = "SELECT u.nombre_usuario, u.nombre, u.nivel
            FROM `usuarios` u
            WHERE u.`id_usuario` =".$usuario." AND u.`activo` = 0;";
    $res = mysql_query($sql);
    $row = mysql_fetch_array($res);

    $nombre_usuario = $row["nombre_usuario"];
    $nombre = $row["nombre"];
    $nivel = $row["nivel"];


}

$nuevo_nivel = @$_POST["nivel"];
$cmd = @$_POST["cmd"];

if( $cmd == "nivel" ) {
    $sql_cambiar = "UPDATE usuarios SET nivel = '".$nuevo_nivel."' WHERE id_usuario = ".$usuario.";";
    $res_cambiar = mysql_query($sql_cambiar);
    if (!$res_cambiar){
        $error = "Ocurrio un error al querer cambiar el nivel por favor intente nuevamente o comuniquese con el Administrador del Sistema. Gracias! :P ";        
    }
}

$conn_obj->close();

?>

