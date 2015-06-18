<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1
 */
/*Con include_once llamamos a la p‡gina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php");
include_once($APP_PATH . "/Classes/Connection.php");

//Instancia los objetos
$conn_obj = new Connection();

//Traigo los datos con el mŽtodo GET
$id = $_GET["id"];
$dni_v = $_GET["dni"];

//Abro la conexi—n
$conn_obj->open();

$borrar = "UPDATE intervencion_cabecera SET activo = 1 where id_intervencion =".$id.";";
$res = mysql_query($borrar);
header('location:intervencion.php?dni='.$dni_v);
exit;

?>