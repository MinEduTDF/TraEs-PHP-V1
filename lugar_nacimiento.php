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
<h3>Lugar de Nacimiento</h3>
<table>
    <tr>
        <th>Descripci&oacute;n</th>
        <th>Modificar</th>
    </tr>
<?php
$row_lug = mysql_fetch_row($combo_lugarnac);

if ($row_lug > 0){ 
    do { 
        echo "<tr>
                <td>".$row_lug[1]."</td>
                <td align='center'><a href='modificar.php?id=".$row_lug[0]."&maestro=lugarnac'><img src='imgs/modificar.png' alt='Modificar'></a></td>
            </tr>";
    } while ($row_lug = mysql_fetch_row($combo_lugarnac));
}
?>
</table><br><br>

<!--Formulario para agregar Lugar de Nacimiento -->

<form action="lugar_nacimiento.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Agregar una Lugar de Nacimiento</legend>
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
