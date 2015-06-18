<?php

/**
 * @author Victoria Marino
 * @package Index
 * @version 1.0
 */

/*Con include_once llamamos a la p‡gina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Combo.php");

?>
<h3>Tipos de cursos</h3>
<table>
    <tr>
        <th>Descripci&oacute;n</th>
        <th>Modificar</th>
    </tr>
<?php
$row_t = mysql_fetch_row($combo_tipocurso);

if ($row_t > 0){ 
    do { 
        echo "<tr>
                <td>".$row_t[1]."</td>
                <td align='center'><a href='modificar.php?id=".$row_t[0]."&maestro=tipocurso'><img src='imgs/modificar.png' alt='Modificar'></a></td>
            </tr>";
    } while ($row_t = mysql_fetch_row($combo_tipocurso));
}
?>
</table><br><br>

<!--Formulario para agregar Turno -->

<form action="tipocurso.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Agregar un Tipo de curso</legend>
        <label for="descripcion">Descripci&oacute;n: </label><input type="text" name="descripcion" /><br/>
	<br/>
        <input type="submit" value="Ingresar" class="boton">
    </fieldset>
    <input type="hidden" name="activo" value="0"/>
    <input type="hidden" name="cmd" value="carga"/>
</form>
<br><br>

<?php
echo @$cargado;
?>
<br>
<?php
echo @$error;

include_once($APP_PATH . "/includes/footer.php");
?>
