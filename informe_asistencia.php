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
include_once($APP_PATH . "/Classes/Connection.php");
include_once($APP_PATH . "/Classes/Date.php");

$fecha_actual = date("d/m/Y");
?>
<form action="informe_asistencia.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Asistencia</legend>
        <label for="tipocurso">Tipo de Curso: </label><select name="tipocurso">
		<option value="0" selected="selected">Todos</option>
		<?php
		//Llenar el combo Tipo de Curso
		if ($row_tc = mysql_fetch_array($combo_tipocurso)){
			do { 
				echo '<option value= "'.$row_tc["id_tipocurso"].'">'.$row_tc["descripcion"].'</option>';
			} while ($row_tc = mysql_fetch_array($combo_tipocurso));
		}
		?>
        </select><br/>
        <labeL for="fecha_informe">Fecha: </label><input type="text" name="fecha_informe" value="<?php echo $fecha_actual; ?>" style="max-width:100px" id="mascarafecha"/></br>
        <input type="submit" value="Buscar" class="boton">
    </fieldset>
    <input type="hidden" name="cmd" value="informe"/>
</form>

<?php

//  instancia los objetos
$conn_obj = new Connection();
$fecha = new Date();

//Traigo el dato para buscar.
$tipocurso = @$_POST["tipocurso"];
$fecha_informe = $fecha ->form2sql(@$_POST["fecha_informe"]);
$cmd = @$_POST["cmd"];

if( $cmd == "informe") {
?>
    <h2>Listado de cursos <?php echo @$_POST["fecha_informe"]; ?></h2>
    <br>
    <table>
<?php
    //  abre la conexion
    $conn_obj->open();

    //Realizo la consulta de los cursos que se tomaron lista para un Turno determinado y una fecha determinada.

    $sql = "SELECT la.tipo_curso, tc.descripcion AS des_tipocurso, la.curso AS curso, c.descripcion AS des_curso, la.division AS division, d.descripcion AS des_division, p.presentes, a.ausentes, tc.tardes_cuarto, tm.tardes_media, ap.aus_permanencia, count(*) AS total
            FROM `lista_alumnos` la
			LEFT OUTER JOIN `tipo_curso` tc ON tc.`id_tipocurso` = la.`tipo_curso`
            LEFT OUTER JOIN `cursos` c ON c.`id_curso` = la.`curso`
            LEFT OUTER JOIN `divisiones` d ON d.`id_division` = la.`division`
            LEFT OUTER JOIN 
            (SELECT fecha, tipo_curso, curso, division, count(*) AS presentes FROM `lista_alumnos`
            WHERE `estado` = 'P' GROUP BY fecha, tipo_curso, curso, division, `estado`) p ON p.fecha = la.fecha AND p.tipo_curso = la.tipo_curso AND p.curso = la.curso AND p.division = la.division
            LEFT OUTER JOIN 
            (SELECT fecha, tipo_curso, curso, division, count(*) AS ausentes FROM `lista_alumnos`
            WHERE `estado` = 'A' GROUP BY fecha, tipo_curso, curso, division, `estado`) a ON a.fecha = la.fecha AND a.tipo_curso = la.tipo_curso AND a.curso = la.curso AND a.division = la.division
            LEFT OUTER JOIN 
            (SELECT fecha, tipo_curso, curso, division, count(*) AS tardes_cuarto FROM `lista_alumnos`
            WHERE `estado` = 'TC' GROUP BY fecha, tipo_curso, curso, division, `estado`) tc ON tc.fecha = la.fecha AND tc.tipo_curso = la.tipo_curso AND tc.curso = la.curso AND tc.division = la.division
            LEFT OUTER JOIN 
            (SELECT fecha, tipo_curso, curso, division, count(*) AS tardes_media FROM `lista_alumnos`
            WHERE `estado` = 'TM' GROUP BY fecha, tipo_curso, curso, division, `estado`) tm ON tm.fecha = la.fecha AND tm.tipo_curso = la.tipo_curso AND tm.curso = la.curso AND tm.division = la.division
            LEFT OUTER JOIN 
            (SELECT fecha, tipo_curso, curso, division, count(*) AS aus_permanencia FROM `lista_alumnos`
            WHERE `estado` = 'AP' GROUP BY fecha, tipo_curso, curso, division, `estado`) ap ON ap.fecha = la.fecha AND ap.tipo_curso = la.tipo_curso AND ap.curso = la.curso AND ap.division = la.division
            WHERE la.fecha = '".$fecha_informe."'
            AND (la.tipo_curso = ".$tipocurso." or ".$tipocurso." = 0)
            GROUP BY la.tipo_curso, c.descripcion, d.descripcion, p.presentes, a.ausentes, tc.tardes_cuarto, tm.tardes_media, ap.aus_permanencia;";
    $res = mysql_query($sql);
    $row = mysql_num_rows($res);

    //Armo una tabla con los resultados, con link a la lista de alumnos.
    if( $row > 0 )
    {
?>
        <tr>
            <th>Tipo Curso</th>
            <th>Curso</th>
            <th>Divisi&oacute;n</th>
            <th>Presentes</th>
            <th>Ausentes</th>
            <th>Tardes<br>1/4 falta</th>
            <th>Tardes<br>1/2 falta</th>
            <th>Ausente con<br>permanencia</th>
            <th>Total</th>
        </tr>
<?php
        while($rs = mysql_fetch_array($res))
        {
            ?>
            <tr align="center">
            <td><?php echo $rs["des_tipocurso"]; ?></td>
            <td><?php echo $rs["des_curso"]; ?></td>
            <td><?php echo $rs["des_division"]; ?></td>
            <td><?php echo $rs["presentes"]; ?></td>
            <td><?php echo $rs["ausentes"]; ?></td>
            <td><?php echo $rs["tardes_cuarto"]; ?></td>
            <td><?php echo $rs["tardes_media"]; ?></td>
            <td><?php echo $rs["aus_permanencia"]; ?></td>
            <td><?php echo $rs["total"]; ?></td>
            <td><a href="detalle_asistencia.php?cur=<?php echo $rs['curso']; ?>&div=<?php echo $rs['division']; ?>&fec=<?php echo $fecha_informe; ?>&tc=<?php echo $rs["tipo_curso"]; ?>"><img src="imgs/btn_mas_info.png" alt="Lista de alumnos"></a></td>
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
include_once($APP_PATH . "/includes/footer.php");
?>
