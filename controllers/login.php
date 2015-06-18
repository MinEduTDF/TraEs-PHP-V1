<?php
/**
 * @author Victoria Marino
 * @package controllers
 * @version 1.2
 */
//Con include_once llamamos a la p‡gina de referencia y la mostramos
include_once(dirname(__FILE__) . "/../includes/common.php");
include_once($APP_PATH . "/Classes/Connection.php");

// Inicia la session.
@ob_start();
@session_start();

//  instancia los objetos
$conn_obj = new Connection();

//Traigo los datos con el mŽtdo POST para que no se vean en la barra URL con "cmd" indico el comando que estoy ejecutando
$cmd = @$_POST["cmd"];
$usuario = @$_POST["usuario"];
$clave = @$_POST["clave"];

//Con el if controlar si se va a loguear o desloguear
if( $cmd == "login" ) {
    
    //  abre la conexion
    $conn = $conn_obj->open();

    //Llamo el SP para validar el usuario que tengo en la BD  
    $sql = "CALL validar_usuario('".$usuario."','".$clave."',0);";
    $res = mysql_query($sql);
    $flag = 0;
    if ( $rs = mysql_fetch_assoc($res) ) {
        $flag = $rs["flag"];
    }

    //Indico que hacer si el usuario es valido Flag=1 o no
    $msg = "Los datos ingresados son incorrectos";

    if ( $flag == 1) {
        $_SESSION["id_usuario"] = $rs["nombre_usuario"];
        $_SESSION["nombre"] = $rs["nombre"];
        $_SESSION["nivel"] = $rs["nivel"];
        header("location:index.php");
        exit;
        }

    //  cierra la conexion
    $conn_obj->close();

} elseif ( $cmd == "logoff" ) {
    session_destroy();
    header("location:/traes/login.php");
};


?>
