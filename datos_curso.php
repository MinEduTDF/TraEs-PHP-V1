<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1.0
 */
/*Con include_once llamamos a la pagina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Combo.php");

$fecha_actual=date("d/m/Y");

if ($activo == 0) {
?>
<!--Formulario para elegir el tipo de curso-->
<form action="datos_curso.php" method="post">
	<fieldset>
		<legend>Elegir tipo de curso</legend>
			<select name="tipo_curso">
				<option value="R">Curso Regular</option>
				<option value="T">Curso Taller</option>
				<option value="E">Curso Educaci&oacute;n F&iacute;sica</option>
			</select>
			<br>
	        <input type="submit" value="Buscar" class="boton">
    </fieldset>
    <input type="hidden" name="cmd" value="buscar"/>
</form>

<?php } elseif ($activo == 1 && ($tipo_curso == "R" || $tipo_curso=="T")) { ?>

<!--Formulario -->
<form action="" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Cursos</legend>
		<?php 
		//Verifico si se trata de un curso de taller
		if ($tipo_curso == "T"){ ?>
        <label for="taller"><?php echo $nombre_taller; ?>: </label><select name="taller">
		    <?php
		    //Llenar el combo Taller
		    if ($row_t = mysql_fetch_array($combo_taller)){ 
		        do { 
		            echo '<option value= "'.$row_t["id_taller"].'">'.$row_t["descripcion"].'</option>';
		        } while ($row_t = mysql_fetch_array($combo_taller));
		    }        
		    ?>
        </select><br/>
		<?php } //Cierra el elseif de tipo de curso ?>
        <label for="curso">Curso: </label><select name="curso">
		    <?php
		    //Llenar el combo Curso
		    if ($row_c = mysql_fetch_array($combo_curso)){ 
		        do { 
		            echo '<option value= "'.$row_c["id_curso"].'">'.$row_c["descripcion"].'</option>';
		        } while ($row_c = mysql_fetch_array($combo_curso));
		    }        
		    ?>
        </select><br/>
        <label for="division">Divisi&oacute;n: </label><select name="division">
		    <?php
		    //Llenar el combo Division
		    if ($row_d = mysql_fetch_array($combo_division)){ 
		        do { 
		            echo '<option value= "'.$row_d["id_division"].'">'.$row_d["descripcion"].'</option>';
		        } while ($row_d = mysql_fetch_array($combo_division));
		    }        
		    ?>
        </select><br/>
        <br/>
        <input type="submit" value="Buscar" class="boton">
    </fieldset>
    <input type="hidden" name="cmd" value="buscar"/>
    <input type="hidden" name="fecha" value="<?php echo $fecha_actual; ?>"/>
    <input type="hidden" name="tipo_curso" value="<?php echo $tipo_curso; ?>"/>
</form>

<?php
} //Cierra el elseif de activo.
include_once($APP_PATH . "/includes/footer.php"); 

?>
