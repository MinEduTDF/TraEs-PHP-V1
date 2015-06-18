<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 2
 */
/*Con include_once llamamos a la pagina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Connection.php");
include_once($APP_PATH . "/Classes/Date.php");
//  instancia los objetos
$conn_obj = new Connection();
$fecha = new Date();

$cmd2 = @$_GET["cmd2"];
$id_asistencia = @$_GET["id"];
$nueva_asistencia = @$_GET["nueva_asis"];
$fecha_nueva = date("Ymd");

if ($cmd2 == "cambiar"){
//  abre la conexion
$conn_obj->open();

	$cambiar="UPDATE lista_alumnos SET 
	estado='".$nueva_asistencia."',
	usuario='".$_SESSION["id_usuario"]."',
	fecha_cambio='".$fecha_nueva."'
	where id = ".$id_asistencia.";";
	$sql_cambiar = mysql_query($cambiar);

    if (!($sql_cambiar)) {
        $error = "Problemas para modificar los datos, compruebe que este todo ok. ".$cambiar;
    } else {
        $error = "Se realizaron los cambios correctamente.";
    }

//  cierra la conexion
$conn_obj->close();
}
?>
