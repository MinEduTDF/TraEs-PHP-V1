<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1
 */
/*Con include_once llamamos a la p‡gina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/Classes/Connection.php");
include_once($APP_PATH . "/includes/valid_session.php"); 

//Instancia los objetos
$conn_obj = new Connection();

//Traigo los datos con el mŽtodo GET
$id = $_GET["id"];
$dni_v = $_GET["dni"];
$fechabaja = date("Ymd");

//Abro la conexi—n
$conn_obj->open();

$baja = "UPDATE cursos_alumnos SET fecha_hasta = '".$fechabaja."', usuario_baja = '".$_SESSION["id_usuario"]."' where id = ".$id.";";
$res = mysql_query($baja);

header('location:inscripcion_curso.php?dni='.$dni_v);
exit;

?>
