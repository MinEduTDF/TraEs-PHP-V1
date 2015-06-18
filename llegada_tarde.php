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

if($_SESSION["nivel"]==1 || $_SESSION["nivel"]==2 || $_SESSION["nivel"]==3 || $_SESSION["nivel"]==5){

if($_SESSION["nivel"]==1){
    $autorizado="";
} else {
    $autorizado="disabled";
}

$fecha_actual=date("d/m/Y");

?>
<!--Formulario para buscar listado de alumnos que ya tienen como ausente el dia.-->
<form action="lista_ausentes.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Listado de Alumnos Ausentes</legend>
        <label for="fecha">Fecha: </label><input type="text" name="fecha" value="<?php echo $fecha_actual; ?>" <?php echo $autorizado; ?>/><br>
        <label for="tipocurso">Tipo de Curso: </label><select name="tipocurso">
		<?php
		//Llenar el combo Tipo de Curso
		if ($row_tc = mysql_fetch_array($combo_tipocurso)){ 
			do { 
				echo '<option value= "'.$row_tc["id_tipocurso"].'">'.$row_tc["descripcion"].'</option>';
			} while ($row_tc = mysql_fetch_array($combo_tipocurso));
		}
		?>
        </select><br/>
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
</form>

<?php

} else {
    echo "No tiene autorizaci&oacute;n para cargar Llegadas Tardes";
}
include_once($APP_PATH . "/includes/footer.php"); 

?>
