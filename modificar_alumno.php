<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1.2
 */
/*Con include_once llamamos a la p‡gina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Combo.php");

if($_SESSION["nivel"]==1 || $_SESSION["nivel"]==4){

echo @$alerta;
?>

<form action="modificar_alumno.php" method="post">
    <fieldset>
    <label for="dni">DNI: </label><input type="text" name="dni" value="<?php echo @$_GET["id"]; ?>" /><br>
    <input type="submit" value="Buscar" class="boton">
    <input type="hidden" name="cmd1" value="buscar"/>
    </fieldset>
</form>
<br>
<!--Formulario para modificar datos de un alumno -->

<form action="modificar_alumno.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Datos del alumno</legend>
        <label for="dni">DNI: </label><input type="text" name="dni" value="<?php echo @$dni; ?>" readonly/><br/>
        <label for="apellido">Apellido: </label><input type="text" name="apellido" value="<?php echo @$ape_alumno; ?>" /><br/>
        <label for="nombre">Nombre: </label><input type="text" name="nombre" value="<?php echo @$nom_alumno; ?>" /><br/>
        <label for="alias">Alias: </label><input type="text" name="alias" value="<?php echo @$alias_alumno; ?>" /><br/>
        <label for="lugar_nacimiento">Lugar Nacimiento: </label><select name="lugar_nacimiento">
        <?php
        //Llenar el combo
        if ($row_l = mysql_fetch_array($combo_lugarnac)){ 
            do { 
                ?><option value= "<?php echo @$row_l["id_lugarnacimiento"];?>"<?php if ($row_l["id_lugarnacimiento"] == @$lugar_alumno) { ?> selected="selected" <?php } ?> > <?php echo $row_l["descripcion"];?> </option>
            <?php
            } while ($row_l = mysql_fetch_array($combo_lugarnac));
        }        
        ?>
        </select><br/>
        <label for="nacionalidad">Nacionalidad: </label><select name="nacionalidad">
        <?php
        //Llenar el combo
        if ($row_n = mysql_fetch_array($combo_nacionalidad)){ 
            do { 
                ?><option value= "<?php echo @$row_n["id_nacionalidad"];?>"<?php if ($row_n["id_nacionalidad"] == @$nacionalidad_alumno) { ?> selected="selected" <?php } ?> > <?php echo $row_n["descripcion"];?> </option>
            <?php
            } while ($row_n = mysql_fetch_array($combo_nacionalidad));
        }        
        ?>
        </select><br/>
        <label for="fecha_nacimiento">Fecha Nacimiento: </label><input type="text" name="fecha_nac" value="<?php echo @$fech_alumno; ?>" id="mascarafecha"/><br/>
        <label for="domicilio">Domicilio: </label><input type="text" name="domicilio" value="<?php echo @$dom_alumno; ?>" /><br/>
        <label for="telefono">Tel&eacute;fono: </label><input type="text" name="telefono" value="<?php echo @$tel_alumno; ?>" /><br/>
        <label for="mail">Mail: </label><input type="text" name="mail" value="<?php echo @$mail_alumno; ?>" /><br/>
        <label for="genero">Genero: </label>
        <select name="genero">
            <option value="F" <?php if (@$gen_alumno == "F") { ?> selected="selected" <?php } ?> >Femenino</option>
            <option value="M" <?php if (@$gen_alumno == "M") { ?> selected="selected" <?php } ?> >Masculino</option>
        </select><br/>
        <br>
        <label for="observaciones">Observaciones: </label><input type="text" name="observaciones" value="<?php echo @$obs_alumno; ?>" /><br/>
	<label for="auto_medico"><font size="1">Auto. a trasladar a un Centro M&eacute;dico</font></label>
	<input type="checkbox" name="auto_medico" value=1 <?php if (@$medico_alumno == 1) { ?> checked <?php } ?> /><br>
	<label for="auto_salida"><font size="1">Auto. a salidas did&aacute;cticas</font></label>
	<input type="checkbox" name="auto_salida" value=1 <?php if (@$salida_alumno == 1) { ?> checked <?php } ?>/>
        <br>
	<br>
        <p><font color=#858585>Escuela o Colegio del que proviene</font></p>
        <label for="primaria">Escuela Primaria: </label><select name="primaria">
        <?php
        //Llenar el combo
        if ($row_p = mysql_fetch_array($combo_primaria)){ 
            do { 
                ?><option value= "<?php echo @$row_p["id_primaria"];?>"<?php if ($row_p["id_primaria"] == @$primaria_alumno) { ?> selected="selected" <?php } ?> > <?php echo $row_p["descripcion"];?> </option>
            <?php
            } while ($row_p = mysql_fetch_array($combo_primaria));
        }        
        ?>
        </select><br/>
        <label for="secundario">Colegio Secundario: </label><select name="secundario">
        <?php
        //Llenar el combo
        if ($row_s = mysql_fetch_array($combo_secundario)){
            do {
                ?><option value= "<?php echo @$row_s["id_secundario"];?>"<?php if ($row_s["id_secundario"] == @$secundario_alumno) { ?> selected="selected" <?php } ?> > <?php echo $row_s["descripcion"];?> </option>
            <?php
            } while ($row_s = mysql_fetch_array($combo_secundario));
        }
        ?>
        </select></br>
	<br>
        <input type="submit" value="Modificar" class="boton">
    </fieldset>
    <input type="hidden" name="cmd2" value="modificar"/>
</form>
<br><br>
<input type="button" value="Ver ficha del alumno" onClick="location.href='ficha_alumno.php?id=<?php echo $dni; ?>'"/>
<br><br>

<?php

echo @$error;
} else {
    echo "No tiene autorizaci&oacute;n para Modificar un Alumno";
}
include_once($APP_PATH . "/includes/footer.php");
?>
