<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 2
 */
/*Con include_once llamamos a la p‡gina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Combo.php");

if($_SESSION["nivel"]==1 || $_SESSION["nivel"]==4){

echo @$alerta;

?>

<!--Formulario para agregar un alumno -->
<form action="agregar_alumno.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Datos del alumno</legend>
        <label for="apellido">Apellido: </label><input type="text" name="apellido" /><br/>
        <label for="nombre">Nombre: </label><input type="text" name="nombre" /><br/>
        <label for="alias">Alias: </label><input type="text" name="alias" /><br/>
        <label for="dni">DNI: </label><input type="text" name="dni"/><font size=1px color=#E04748>&#42; Dato Obligatorio</font><br/>
        <label for="lugar_nacimiento">Lugar Nacimiento: </label><select name="lugar_nacimiento"/>
        <?php
        //Llenar el combo
        if ($row_l = mysql_fetch_array($combo_lugarnac)){ 
            do { 
                echo '<option value= "'.$row_l["id_lugarnacimiento"].'">'.$row_l["descripcion"].'</option>';
            } while ($row_l = mysql_fetch_array($combo_lugarnac));
        }        
        ?>        
        </select><br/>
        <label for="nacionalidad">Nacionalidad: </label><select name="nacionalidad">
        <?php
        //Llenar el combo
        if ($row_n = mysql_fetch_array($combo_nacionalidad)){ 
            do { 
                echo '<option value= "'.$row_n["id_nacionalidad"].'">'.$row_n["descripcion"].'</option>';
            } while ($row_n = mysql_fetch_array($combo_nacionalidad));
        }        
        ?>
        </select><br/>
        <label for="fecha_nacimiento">Fecha Nacimiento: </label><input type="text" name="fecha_nac" id="mascarafecha"/><br/>
        <label for="domicilio">Domicilio: </label><input type="text" name="domicilio"/><br/>
        <label for="telefono">Tel&eacute;fono: </label><input type="text" name="telefono"/><br/>
        <label for="mail">Mail: </label><input type="text" name="mail"/><br/>
        <label for="genero">G&eacute;nero: </label>
        <select name="genero">
            <option value="F">Femenino</option>
            <option value="M">Masculino</option>
        </select><br/>
        <label for="observaciones">Observaciones: </label><input type="text" name="observaciones"/><br/>
        <br>
	<label for="auto_medico"><font size="1">Auto. a trasladar a un Ctro M&eacute;dico</font></label>
	<input type="checkbox" name="auto_medico" value="1"/><br>
	<label for="auto_salida"><font size="1">Auto. a salidas did&aacute;cticas</font></label>
	<input type="checkbox" name="auto_salida" value="1"/>
	<br>
        <br>
        <p><font color=#858585>Escuela o Colegio del que proviene</font></p>
        <label for="primaria">Escuela Primaria: </label><select name="primaria">
        <option value="26" selected="selected">Otro</option>
        <?php
        //Llenar el combo
        if ($row_p = mysql_fetch_array($combo_primaria)){ 
            do { 
                echo '<option value= "'.$row_p["id_primaria"].'">'.$row_p["descripcion"].'</option>';
            } while ($row_p = mysql_fetch_array($combo_primaria));
        }        
        ?>
        </select><br/>
        <label for="secundario">Colegio Secundario: </label><select name="secundario">
        <option value="34" selected="selected">Ninguno</option>
        <?php
        //Llenar el combo
        if ($row_s = mysql_fetch_array($combo_secundario)){
            do {
                echo '<option value= "'.$row_s["id_secundario"].'">'.$row_s["descripcion"].'</option>';
            } while ($row_s = mysql_fetch_array($combo_secundario));
        }
        ?>
        </select></br>
	<br>
        <label for="foto">Foto:</label><input name="foto" type="file" />
        <br/><br/>
        <input type="submit" value="Ingresar" class="boton">
    </fieldset>
    <input type="hidden" name="activo" value="0"/>
    <input type="hidden" name="cmd" value="carga"/>
</form>
<br><br>
<input type="button" value="Ver ficha del alumno" onClick="location.href='ficha_alumno.php?id=<?php echo $dni; ?>'"/>
<br><br>

<?php
echo @$cargado;
echo @$nuevo;
?>
<br>
<?php
echo @$error;
} else {
    echo "No tiene autorizaci&oacute;n para cargar un Alumno Nuevo";
}
include_once($APP_PATH . "/includes/footer.php");
?>
