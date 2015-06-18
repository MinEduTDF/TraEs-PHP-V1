<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 2
 */
/*Con include_once llamamos a la pagina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Combo.php");

if($_SESSION["nivel"]==1){

?>

<form action="modificar_asistencia.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Asistencia</legend>
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
        <labeL for="fecha_informe">Fecha: </label><input type="text" name="fecha_informe" style="max-width:100px" id="mascarafecha"/></br>
        <input type="submit" value="Buscar" class="boton">
    </fieldset>
    <input type="hidden" name="cmd" value="lista"/>
</form>

<?php

//Traigo el dato para buscar.
$tipocurso = @$_POST["tipocurso"];
$curso = @$_POST["curso"];
$division = @$_POST["division"];
$fecha_informe = $fecha ->form2sql(@$_POST["fecha_informe"]);
$cmd = @$_POST["cmd"];

if( $cmd == "lista") {
    //  abre la conexion
    $conn_obj->open();
    //Realizo la consulta de la asistencia de los alumnos del curso dado.

    $sql = "SELECT a.`dni`, a.`apellido`, a.`nombre`, la.`estado`, la.`observacion`, la.id
            FROM `lista_alumnos` la 
            INNER JOIN `alumnos` a ON a.`dni` = la.`dni`
            WHERE la.`tipo_curso` = '".$tipocurso."'
            AND la.`curso` = ".$curso."
            AND la.`division` = ".$division."
            AND la.`fecha` = '".$fecha_informe."'
            ORDER BY a.`apellido`;";
    $res = mysql_query($sql);
    $row = mysql_num_rows($res);
?>
    <h2>Listado</h2>
    <br>
    <table>
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Asistencia</th>
            <th>Justificado</th>
            <th>Nuevo Registro</th>
            <th></th>
        </tr>
<?php
    //Armo una tabla con los resultados.
    if( $row > 0 )
	{
		while($rs = mysql_fetch_array($res))
		{
            ?>
            <tr>
				<form>
					<td><?php echo $rs["dni"]; ?></td>
					<td><?php echo $rs["apellido"].", ".$rs["nombre"]; ?></td>
					<td><?php if ($rs["estado"]=="P") { 
								echo "Presente";
							} elseif ($rs["estado"]=="A") { ?>
					<font color="#F6001C"><?php echo "Ausente"; ?></font>
						<?php } elseif ($rs["estado"]=="TC") { ?>
					<font color="#22820B"><?php echo "Tarde 1/4 falta"; ?></font>
						<?php } elseif ($rs["estado"]=="TM") { ?>
					<font color="#2A25F6"><?php echo "Tarde 1/2 falta"; ?></font>
						<?php } elseif ($rs["estado"]=="AP") { ?>
					<font color="#F6400C"><?php echo "Ausente con permanencia"; ?></font>
						<?php }
					?>
					</td>
					<td><?php echo $rs["observacion"]; ?></td>
					<td><select name="nueva_asis">
						<option value="P">Presente</option>
						<option value="A">Ausente</option>
						<option value="TC">Tarde 1/4 falta</option>
						<option value="TM">Tarde 1/2 falta</option>
						<option value="AP">Ausente con permanencia</option>
					</select></td>
					<td><input type="submit" value="Cambiar" class="boton"></td>
					<input type="hidden" name="cmd2" value="cambiar"/>
					<input type="hidden" name="id" value='<?php echo $rs["id"]; ?>'/>
				</form>
            </tr>
            <?php
		}
	}
    else
	{
        ?>
        <tr><td>No se encontraron datos.</td></tr>
        <?php 
	}
    mysql_free_result($res);

    //  cierra la conexion
    $conn_obj->close();
?>
    </table>
<?php
}
echo @$error;

} else {
    echo "No tiene autorizaci&oacute;n para Modificar Asistencia";
}

include_once($APP_PATH . "/includes/footer.php");
?>
