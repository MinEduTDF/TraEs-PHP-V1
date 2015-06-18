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
<h3>Usuarios</h3>
<table>
    <tr>
        <th>Usuario</th>
        <th>Nombre</th>
        <th>Mail</th>
        <th>Fecha<br>Nacimiento</th>
        <th>Nivel</th>
        <th>Estado</th>
        <th>Cambiar Nivel</th>
    </tr>
<?php
$row_u = mysql_fetch_row($combo_usuario);

if ($row_u > 0){ 
    do { 
        echo "<tr>
                <td>".$row_u[1]."</td>
                <td>".$row_u[2]."</td>
		<td>".$row_u[3]."</td>
		<td>".$row_u[4]."</td>
		<td align='center'>".$row_u[5]."</td>
		<td align='center'>".$row_u[6]."</td>
                <td align='center'><a href='cambiar_nivel.php?id=".$row_u[0]."'><img src='imgs/modificar.png' alt='Cambiar Nivel'></a></td>
            </tr>";
    } while ($row_u = mysql_fetch_row($combo_usuario));
}
?>
</table><br><br>

<!--Formulario para agregar Usuario -->

<form action="usuarios.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Agregar un Usuario</legend>
        <label for="usuario">Usuario: </label><input type="text" name="nombre_usuario" /><br/>
        <label for="nombre">Nombre Completo: </label><input type="text" name="nombre" /><br/>
        <label for="clave">Contrase&#241;a:</label><input type="text" name="clave" /><br/>
        <label for="mail">Mail:</label><input type="text" name="mail" /><br/>
        <label for="fecha_nac">Fecha Nacimiento:</label><input type="text" name="fecha_nac" /><br/>
        <label for="nivel">Nivel:</label><input type="text" name="nivel" /><br/>
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
