<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1.2
 */
//Con include_once llamamos a la p‡gina de referencia y la mostramos
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");

?>
<h2>Listado de Alumnos con 3 faltas en el mes</h2>
    <p><?php echo $faltas3; ?></p>
<h2>Listado de Alumnos con 5 faltas en el mes</h2>
    <p><?php echo $faltas5; ?></p>
<h2>Listado de Alumnos con 15 faltas</h2>
    <p><?php echo $faltas15; ?></p>
<h2>Listado de Alumnos con 23 faltas</h2>
    <p><?php echo $faltas23; ?></p>
<h2>Listado de Alumnos con 25 faltas</h2>
    <p><?php echo $faltas25; ?></p>


<?php

include_once($APP_PATH . "/includes/footer.php");
?>