<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 2
 */
//Con include_once llamamos a la p‡gina de referencia y la mostramos
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Combo.php");

//Traigo los datos con el metdo POST para que no se vean en la barra URL
$tipocurso = @$_POST["tipocurso"];
$curso = @$_POST["curso"];
$division = @$_POST["division"];
$cmd = @$_POST["cmd"];
$fecha_actual= (@$_POST["fecha"]=="") ? date("d/m/Y") : @$_POST["fecha"];
$fec_sql = $fecha ->form2sql($fecha_actual);

if( $cmd == "buscar" ) {
    $conn_obj->open();
    
    //Busco las descripciones para el titulo
    $select = "SELECT tc.`descripcion` AS tipocurso, c.`descripcion` AS curso, d.`descripcion` AS division
            FROM `tipo_curso` tc, `cursos` c, `divisiones` d
            WHERE 
            tc.`id_tipocurso` = ".$tipocurso."
            AND c.`id_curso` = ".$curso."
            AND d.`id_division` = ".$division.";";
    $descripciones = mysql_query($select);
    $descripcion = mysql_fetch_array($descripciones);
?>

<h2><?php echo $descripcion["tipocurso"]." ".$descripcion["curso"]." ".$descripcion["division"]; ?></h2>
<br>

<?php
//Busco si ya se tomo lista para el curso en el dia de la fecha actual.
    $lista = "SELECT lc.`fecha_carga`, lc.`usuario`, u.`nombre`, tc.`op_nocursa` FROM `lista_cursos` lc
            LEFT OUTER JOIN `usuarios` u ON u.`nombre_usuario` = lc.`usuario`
            LEFT OUTER JOIN `tipo_curso` tc ON tc.`id_tipocurso` = lc.`tipo_curso`
            WHERE lc.`tipo_curso` = ".$tipocurso."
            AND lc.`curso` = ".$curso."
            AND lc.`division` = ".$division."
            AND lc.`fecha` = '".$fec_sql."';";
    $res_lista = mysql_query($lista);
    $row_lista = mysql_num_rows($res_lista);
    $rs_lista = mysql_fetch_array($res_lista);

    if($row_lista > 0) {

	//Si se tomo lista pero es un tipo de curso del que se puede tomar lista varias veces entonces muestro los alumnos que todavía no se les tomo.    
		if($rs_lista["op_nocursa"]==1) {
			$alumnos_nocursan = "SELECT a.dni, a.apellido, a.nombre FROM alumnos a
			INNER JOIN cursos_alumnos ca ON a.dni = ca.dni AND ca.id_tipocurso = ".$tipocurso." AND fecha_hasta is null
			INNER JOIN lista_alumnos la ON a.dni = la.dni AND la.tipo_curso = ".$tipocurso." AND la.estado = 'N' AND la.fecha = ".$fec_sql."
                	WHERE
                	ca.`id_tipocurso` = ".$tipocurso."
                	AND ca.`id_curso` = ".$curso."
                	AND ca.`id_division` = ".$division."
                	ORDER BY a.`apellido`;";
        	$res = mysql_query($alumnos_nocursan);
        	$row = mysql_num_rows($res);
		} else {
        	?>
        	<p>Ya se tomo lista para este curso por el usuario: <?php echo $rs_lista["nombre"]; ?>, en el d&iacute;a <?php echo $rs_lista["fecha_carga"]; ?>.<p>
        	<input type="button" value="Hacer otra busqueda" onClick="location.href='tomar_asistencia.php'"/>
        	<?php 
        }
    } else {

//Si no se tomo lista para el curso entonces hago la consulta para el listado de alumnos del curso.

        $sql = "SELECT a.`dni`, a.`apellido`, a.`nombre` FROM `alumnos` a
			INNER JOIN cursos_alumnos ca ON a.dni = ca.dni AND ca.id_tipocurso = ".$tipocurso." AND fecha_hasta is null
			WHERE
            ca.`id_tipocurso` = ".$tipocurso."
            AND ca.`id_curso` = ".$curso."
            AND ca.`id_division` = ".$division."
            ORDER BY a.`apellido`;";
        $res = mysql_query($sql);
        $row = mysql_num_rows($res);
        
	}
	if( $row > 0 ) {
    ?>
		<h3>Fecha: <?php echo $fecha_actual; ?></h3>
        <form action="lista_alumnos.php" method="post">
			<input type="hidden" name="fecha" value="<?php echo $fecha_actual; ?>"/><br/>
            <table>
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
					<?php if ($rs_lista["op_nocursa"]==1) { echo "<th>No cursa</th>"; } ?>
                    <th>Presente</th>
                    <th>Ausente</th>
                </tr>
            <?php
            while($rs = mysql_fetch_array($res))
            {
                $i=$i+1;
                ?>            
                <tr>
					<td><?php echo $rs["dni"]; ?></td>
					<td><?php echo $rs["apellido"].", ".$rs["nombre"]; ?></td>
					<?php if ($rs_lista["op_nocursa"]==1) { echo "<td><input type='radio' name=".$i." value='N' checked='checked'/></td>"; } ?>
					<td><input type="radio" name="<?php echo $i; ?>" value="P" <?php if ($rs_lista["op_nocursa"]==0) { echo "checked='checked'"; } ?>/></td>
					<td><input type="radio" name="<?php echo $i; ?>" value="A" /></td>
					<td><input type="hidden" name="ids[]" value="<?php echo $rs['dni']; ?>"/></td>
                </tr>                
            <?php
			}
            ?>
            </table><br>
            <input type="hidden" name="curso" value="<?php echo $curso; ?>" />
            <input type="hidden" name="division" value="<?php echo $division; ?>" />
            <input type="hidden" name="tipo_curso" value="<?php echo $tipocurso; ?>" />
            <input type="hidden" name="lista_nueva" value="<?php echo $row_lista; ?>" />
            <input type="hidden" name="cmd" value="confirmar" />
            <input type="submit" value="Confirmar" />
		</form>
        <?php
    } else {
	//Si no encuentra alumnos para Curso le da la posibilidad de realizar otra busqueda.
		?>
        <p>No hay alumnos para ese Curso<p>
        <input type="button" value="Hacer otra busqueda" onClick="location.href='tomar_asistencia.php'"/>
        <?php 
    }

mysql_free_result($res);
mysql_free_result($descripciones);
mysql_free_result($res_lista);
    
//  cierra la conexion
$conn_obj->close();
}
echo @$error;
include_once($APP_PATH . "/includes/footer.php"); 

?>
