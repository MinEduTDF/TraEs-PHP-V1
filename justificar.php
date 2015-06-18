<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 2
 */
//Con include_once llamamos a la pagina de referencia y la mostramos
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");

$row = mysql_fetch_array($res);

?>

<h2>Justificar Ausencia/Tarde del Alumno: <?php echo $row["nombre"]." ".$row["apellido"]; ?></h2>
<form action="justificar.php" method="post">
    <fieldset>
        <label for="fecha">Fecha:</label><input type="text" name="fecha" value="<?php echo $fecha_f ->sql2form($row['fecha']);?>" disabled /><br>
        <label for="estado">Estado:</label><input type="text" name="estado" value="<?php echo $row['estado'];?>" disabled /><br>
        <label for="estado">Curso:</label><input type="text" name="curso" value="<?php echo $row['tipo_curso'];?>" disabled /><br>
        <label for="justificado">Justificado:</label><input type="checkbox" name="justificado" value=1 /><br>
        <label for="observacion">Observaci&oacute;n:</label><input type="text" name="observacion" value="<?php echo $row['observacion'];?>"/><br><br>
        <input type="submit" value="Justificar" class="boton">
    </fieldset>
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <input type="hidden" name="dni" value="<?php echo $row['dni']; ?>" />
    <input type="hidden" name="cmd" value="justificar" />
</form>    
<br>
<input type="button" value="Volver" onClick="location.href='asistencia_alumno.php?id=<?php echo $row['dni']; ?>'"/>
<br><!-- Boton para ver el Informe por alumno de inasistencia y poder justificar las faltas. Lleva a una pagina nueva. -->
<br>

<?php

echo @$error;

include_once($APP_PATH . "/includes/footer.php");
?>
