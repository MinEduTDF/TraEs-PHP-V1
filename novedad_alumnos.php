<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1
 */
//Con include_once llamamos a la p‡gina de referencia y la mostramos
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Connection.php");
include_once($APP_PATH . "/Classes/Combo.php");
include_once($APP_PATH . "/Classes/Date.php");

//  instancia los objetos
$conn_obj = new Connection();
$fecha_d = new Date();


//Traigo los datos con el metdo POST para que no se vean en la barra URL
$taller = (@$_POST["taller"]=="") ? 0 : @$_POST["taller"];
$curso = @$_POST["curso"];
$division = @$_POST["division"];
$cmd = @$_POST["cmd"];
$tipo_curso = @$_POST["tipo_curso"];
$fecha_actual= (@$_POST["fecha"]=="") ? date("d/m/Y") : @$_POST["fecha"];
$fec_sql = $fecha_d ->form2sql($fecha_actual);

if( $cmd == "buscar" ) {
    $conn_obj->open();
    
    //Busco las descripciones para el titulo
    $select = "SELECT t.`descripcion` AS taller, c.`descripcion` AS curso, d.`descripcion` AS division
            FROM `talleres` t, `cursos` c, `divisiones` d
            WHERE 
            (t.`id_taller` = ".$taller." or ".$taller." = 0)
            AND c.`id_curso` = ".$curso."
            AND d.`id_division` = ".$division.";";
    $descripciones = mysql_query($select);
    $descripcion = mysql_fetch_array($descripciones);

?>

<h2>
	<?php 
	if($tipo_curso=="T"){
		echo $descripcion["taller"]." ".$descripcion["curso"]." ".$descripcion["division"];
	} elseif ($tipo_curso=="R") {
		echo $descripcion["curso"]." ".$descripcion["division"];
	}
	?>
</h2>
<br>
<?php

        $sql1 = "SELECT a.`dni`, a.`apellido`, a.`nombre`
                FROM `alumnos` a";
		if($tipo_curso == "T"){
        $sql2 = " INNER JOIN `alumnos_talleres` ac ON a.`id_alumno_taller` = ac.`id_alumno_taller`
                WHERE
                ac.`id_taller` = '".$taller."'
                AND ac.`id_curso` = ".$curso."
                AND ac.`id_division` = ".$division."
                ORDER BY a.`apellido`;";	
		} elseif ($tipo_curso == "R") {
		$sql2 = " INNER JOIN `alumnos_cursos` ac ON a.`id_alumno_curso` = ac.`id_alumno_curso`
                WHERE
                ac.`id_curso` = ".$curso."
                AND ac.`id_division` = ".$division."
                ORDER BY a.`apellido`;";
		}
		$sql = $sql1.$sql2;
        $res = mysql_query($sql);
        $row = mysql_num_rows($res);
        
		if( $row > 0 ) {
        ?>
            <form action="novedad_alumnos.php" method="post">
                <input type="hidden" name="fecha" value="<?php echo $fecha_actual; ?>"/>
                <br/><br/>
                <table>
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Sin Novedad</th>
                    <th>Pasa de anio</th>
                    <th>Egresa</th>
                    <th>Pase a otro<br>colegio</th>
                    <th>Abandona</th>
                    <th>Otro</th>
                </tr>
            <?php
            while($rs = mysql_fetch_array($res))
            {
                $i=$i+1;
                ?>            
                <tr>
                <td><?php echo $rs["dni"]; ?></td>
                <td><?php echo $rs["apellido"].", ".$rs["nombre"]; ?></td>
                <td><input type="radio" name="<?php echo $i; ?>" value="N" checked="checked"/></td><!--Sin Novedad-->
                <td><input type="radio" name="<?php echo $i; ?>" value="P" /></td><!--Pasa de anio-->
                <td><input type="radio" name="<?php echo $i; ?>" value="E" /></td><!--Egresa-->
                <td><input type="radio" name="<?php echo $i; ?>" value="C" /></td><!--Pasa a otro colegio-->
                <td><input type="radio" name="<?php echo $i; ?>" value="A" /></td><!--Abandona-->
                <td><input type="radio" name="<?php echo $i; ?>" value="O" /></td><!--Otro-->
                <td><input type="hidden" name="ids[]" value="<?php echo $rs['dni']; ?>"/></td>
                </tr>
                
                <?php
            }
            ?>
                </table><br>
                <input type="hidden" name="taller" value="<?php echo $taller; ?>" />
                <input type="hidden" name="curso" value="<?php echo $curso; ?>" />
                <input type="hidden" name="division" value="<?php echo $division; ?>" />
                <input type="hidden" name="tipo_curso" value="<?php echo $tipo_curso; ?>" />
                <input type="hidden" name="cmd" value="confirmar" />
                <input type="submit" value="Confirmar" />
            </form>
            <?php
        } else {
	//Si no encuentra alumnos para Curso le da la posibilidad de realizar otra busqueda.

            ?>
            <p>No hay alumnos para ese Curso<p>
            <input type="button" value="Hacer otra busqueda" onClick="location.href='novedad_curso.php'"/>
            <?php 
        }   
        mysql_free_result($res);
    
    
//  cierra la conexion
$conn_obj->close();
}
echo @$error;
include_once($APP_PATH . "/includes/footer.php"); 

?>
