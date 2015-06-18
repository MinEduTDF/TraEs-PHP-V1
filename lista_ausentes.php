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
$estado = "A";

//echo $tipocurso." ".$curso." ".$division." ".$tipo_curso." ".$fecha_actual." ".$fec_sql;
    
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

<h2>Listado de Ausentes <br><?php echo $descripcion["tipocurso"]." ".$descripcion["curso"]." ".$descripcion["division"]; ?></h2>
<br>

<?php
//Busco si ya se tomo lista para el curso en el dia seleccionado.
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

    if(!$row_lista)
    {
        ?>
        <p>Todav&iacute;a no se tomo lista para este curso en el d&iacute;a <?php echo $fecha_actual; ?><p>
        <input type="button" value="Hacer otra busqueda" onClick="location.href='llegada_tarde.php'"/>
        <?php
        
    } else {

//Si se tomo lista para el curso entonces hago la consulta para el listado de alumnos del curso.
        $sql = "SELECT la.id, a.`dni`, a.`apellido`, a.`nombre`
                FROM `lista_alumnos` la
                INNER JOIN `alumnos` a ON a.`dni` = la.`dni`
				INNER JOIN cursos_alumnos ca ON a.dni = ca.dni AND ca.id_tipocurso = ".$tipocurso." AND fecha_hasta is null
                WHERE
                ca.`id_tipocurso` = ".$tipocurso."
                AND ca.`id_curso` = ".$curso."
                AND ca.`id_division` = ".$division."
                AND la.`estado` = '".$estado."'
                AND (la.`justificado` IS NULL OR la.`justificado` = 0)
                AND la.`fecha` = '".$fec_sql."'
                ORDER BY a.`apellido`;";

        $res = mysql_query($sql);
        $row = mysql_num_rows($res);

        if( $row > 0 )
        {
        ?>
            <h3>Fecha: <?php echo $fecha_actual; ?></h3>
            <form action="lista_ausentes.php" method="post">
                <input type="hidden" name="fecha" value="<?php echo $fecha_actual; ?>"/>
                <br/><br/>
                <table>
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Ausente</th>
                    <th>Tarde<br>1/4 falta</th>
                    <th>Tarde<br>1/2 falta</th>
                    <th>Ausente con<br>permanencia</th>
                    <th>Justificado</th>
                    <th>Observaci&oacute;n</th>
                </tr>
            <?php
            while($rs = mysql_fetch_array($res))
            {
                $i=$i+1;
                ?>            
                <tr align="center">
                <td><?php echo $rs["dni"]; ?></td>
                <td><?php echo $rs["apellido"].", ".$rs["nombre"]; ?></td>
                <td><input type="radio" name="<?php echo $i; ?>" value="A" checked="checked"/></td>
                <td><input type="radio" name="<?php echo $i; ?>" value="TC" /></td>
                <td><input type="radio" name="<?php echo $i; ?>" value="TM" /></td>
                <td><input type="radio" name="<?php echo $i; ?>" value="AP" /></td>
                <td><input type="checkbox" name="<?php echo "j".$i; ?>" value="1" style="max-width:20px"/></td>
                <td><input type="text" name="<?php echo "o".$i; ?>" value="" /></td>
                <td><input type="hidden" name="ids[]" value="<?php echo $rs['id']; ?>"/></td>
                </tr>
                
                <?php
            }
            ?>
                </table><br>
                <input type="hidden" name="cmd" value="confirmar" />
                <input type="submit" value="Confirmar" />
            </form>
            <?php
        }
        else
        {

//Si no encuentra alumnos le da la posibilidad de realizar otra busqueda.

            ?>
            <p>No hay alumnos ausentes para este Curso<p>
            <input type="button" value="Hacer otra busqueda" onClick="location.href='llegada_tarde.php'"/>
            <?php 
        }   
        mysql_free_result($res);
    }
    
//  cierra la conexion
$conn_obj->close();
}
echo @$error;
include_once($APP_PATH . "/includes/footer.php"); 

?>
