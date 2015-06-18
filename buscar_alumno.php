<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1.2
 */
/*Con include_once llamamos a la p‡gina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");?>

<!--Formulario para buscar un alumno por Apellido o por DNI-->

<form action="buscar_alumno.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Buscar Alumno</legend>
        <label for="apellido">Apellido: </label><input type="text" name="apellido" /><br/>
        <label for="dni">DNI: </label><input type="text" name="dni" value="0" /><br/>
        <br/>
        <input type="submit" value="Buscar" class="boton">
    </fieldset>
    <input type="hidden" name="cmd" value="buscar"/>
</form>
<br>
<p><font color=#C6C7C5 >El DNI no debe contener puntos, rayas, ni espacios.</font></p>
<br>
<?php
echo @$error;
include_once($APP_PATH . "/includes/footer.php"); 

?>