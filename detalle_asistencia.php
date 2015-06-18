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
include_once($APP_PATH . "/Classes/Connection.php");
include_once($APP_PATH . "/Classes/Date.php");


//  instancia los objetos
$conn_obj = new Connection();
$fecha_d = new Date();

//Traigo el dato para buscar.
$curso = $_GET["cur"];
$division = $_GET["div"];
$fecha= $_GET["fec"];
$tipocurso= $_GET["tc"];

$fec_vista = $fecha_d->sql2form($fecha);

//  abre la conexion
$conn_obj->open();
$titulo = "SELECT tc.descripcion AS tipocurso, c.`descripcion` AS curso, d.`descripcion` AS division
            FROM `tipo_curso` tc, `cursos` c, `divisiones` d
            WHERE
            tc.`id_tipocurso` = ".$tipocurso." 
            AND c.`id_curso` = ".$curso."
            AND d.`id_division` = ".$division.";";
$res_titulo = mysql_query($titulo);
$r_titulo = mysql_fetch_array($res_titulo);

?>
    <h2>Detalle del Curso: <?php echo $r_titulo["tipocurso"]." | ".$r_titulo["curso"]." | ".$r_titulo["division"]."<br>".$fec_vista; ?></h2>
    <br>
    <table>
        <tr>
            <th></th>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Asistencia</th>
            <th>Justificado</th>
        </tr>
<?php
    //Realizo la consulta de la asistencia de los alumnos del curso dado.

    $sql = "SELECT a.`dni`, a.`apellido`, a.`nombre`, la.`estado`, la.`observacion`
            FROM `lista_alumnos` la 
            INNER JOIN `alumnos` a ON a.`dni` = la.`dni`
            WHERE la.`tipo_curso` = '".$tipocurso."'
            AND la.`curso` = ".$curso."
            AND la.`division` = ".$division."
            AND la.`fecha` = '".$fecha."'
            ORDER BY a.`apellido`;";
    $res = mysql_query($sql);
    $row = mysql_num_rows($res);

    //Armo una tabla con los resultados.
    if( $row > 0 )
    {
        while($rs = mysql_fetch_array($res))
        {
            ?>
            <tr>
            <td><a href="asistencia_alumno.php?id=<?php echo $rs["dni"]; ?>"><img src="imgs/btn_mas_info.png" alt="Ver inasistencias hist&oacute;ricas"></a></td>            
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
    <br>
    <div align=center>
        <input type="button" value="Volver" onClick="location.href='informe_asistencia.php'"/>
    </div>
<?php
include_once($APP_PATH . "/includes/footer.php");
?>
