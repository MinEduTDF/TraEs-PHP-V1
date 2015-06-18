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
include_once($APP_PATH . "/Classes/Connection.php");
include_once($APP_PATH . "/Classes/Date.php");
include_once($APP_PATH . "/Classes/redimensionar.php");

/*Recibo el DNI del alumno*/

$dni_alumno = $_GET["id"];
$fecha = new Date();
$conn_obj = new Connection();


if ($dni_alumno == 0) {
    echo "No tiene seleccionado ning&uacute;n alumno";
} else {
 
//Realizar consulta SQL
    
    $conn_obj->open();

// Consulta de los datos del alumno resumidos.    
    $sql = "SELECT a.`apellido`, a.`nombre`, a.`alias`, a.`dni`, a.`foto`, a.`fecha_nac`
            FROM `alumnos` a
            WHERE a.`dni` =".$dni_alumno." AND a.`activo` = 0;";
    $res = mysql_query($sql);
    $row = mysql_fetch_array($res);

    $apellido = $row["apellido"];
    $nombre =$row["nombre"];
    $dni = $row["dni"];
    $foto = $row["foto"];
    $fecha_nac = $fecha ->sql2form($row["fecha_nac"]);
        
// Consulta del curso donde se inscribio el alumno
$sql_curso = "SELECT tc.descripcion as tipocurso, c.descripcion as curso, d.descripcion as division, ca.id_tipocurso
FROM `cursos_alumnos` ca 
LEFT OUTER JOIN `tipo_curso` tc ON tc.`id_tipocurso` = ca.`id_tipocurso`
LEFT OUTER JOIN `cursos` c ON c.`id_curso` = ca.`id_curso`
LEFT OUTER JOIN `divisiones` d ON d.`id_division` = ca.`id_division`
WHERE ca.`dni` = ".$dni." AND ca.fecha_hasta IS NULL
ORDER BY ca.id_tipocurso;";
$res_curso = mysql_query($sql_curso);

// Consulta de total de Ausentes, Tardes, Presentes, justificadas o no.
$sql_inasistencias ="select tc.descripcion, p.presente, a.ausentes, aj.ausentes_jus, tc.tardes_cuarto, tjc.tardes_cuarto_jus, tm.tardes_media, tjm.tardes_media_jus, ap.aus_permanencia, apj.aus_permanencia_jus
FROM `lista_alumnos` la
LEFT OUTER JOIN 
(SELECT tipo_curso, dni, count(*) AS presente FROM `lista_alumnos` WHERE `estado` = 'P' GROUP BY tipo_curso, dni, `estado`) p ON p.dni = la.dni AND p.tipo_curso = la.tipo_curso
LEFT OUTER JOIN
(SELECT tipo_curso, dni, count(*) AS ausentes FROM `lista_alumnos` WHERE `estado` = 'A' AND (`justificado`IS NULL OR `justificado`=0) GROUP BY tipo_curso, dni, `estado`) a ON a.dni = la.dni AND a.tipo_curso = la.tipo_curso
LEFT OUTER JOIN 
(SELECT tipo_curso, dni, count(*) AS ausentes_jus FROM `lista_alumnos` WHERE `estado` = 'A' AND `justificado`=1 GROUP BY tipo_curso, dni, `estado`) aj ON aj.dni = la.dni AND aj.tipo_curso = la.tipo_curso
LEFT OUTER JOIN 
(SELECT tipo_curso, dni, count(*) AS tardes_cuarto FROM `lista_alumnos` WHERE `estado` = 'TC' AND (`justificado`IS NULL OR `justificado`=0) GROUP BY tipo_curso, dni, `estado`) tc ON tc.dni = la.dni AND tc.tipo_curso = la.tipo_curso
LEFT OUTER JOIN 
(SELECT tipo_curso, dni, count(*) AS tardes_cuarto_jus FROM `lista_alumnos` WHERE `estado` = 'TC' AND `justificado`=1 GROUP BY tipo_curso, dni, `estado`) tjc ON tjc.dni = la.dni AND tjc.tipo_curso = la.tipo_curso
LEFT OUTER JOIN 
(SELECT tipo_curso, dni, count(*) AS tardes_media FROM `lista_alumnos` WHERE `estado` = 'TM' AND (`justificado`IS NULL OR `justificado`=0) GROUP BY tipo_curso, dni, `estado`) tm ON tm.dni = la.dni AND tm.tipo_curso = la.tipo_curso
LEFT OUTER JOIN 
(SELECT tipo_curso, dni, count(*) AS tardes_media_jus FROM `lista_alumnos` WHERE `estado` = 'TM' AND `justificado`=1 GROUP BY tipo_curso, dni, `estado`) tjm ON tjm.dni = la.dni AND tjm.tipo_curso = la.tipo_curso
LEFT OUTER JOIN 
(SELECT tipo_curso, dni, count(*) AS aus_permanencia FROM `lista_alumnos` WHERE `estado` = 'AP' AND (`justificado`IS NULL OR `justificado`=0) GROUP BY tipo_curso, dni, `estado`) ap ON ap.dni = la.dni AND ap.tipo_curso = la.tipo_curso
LEFT OUTER JOIN 
(SELECT tipo_curso, dni, count(*) AS aus_permanencia_jus FROM `lista_alumnos` WHERE `estado` = 'AP' AND `justificado`=1 GROUP BY tipo_curso, dni, `estado`) apj ON apj.dni = la.dni AND apj.tipo_curso = la.tipo_curso
INNER JOIN tipo_curso tc on tc.id_tipocurso = la.tipo_curso
WHERE la.dni = '".$dni."' AND extract(YEAR FROM la.fecha)= ".$anio_escolar." 
GROUP BY tc.descripcion, p.presente, a.ausentes, aj.ausentes_jus, tc.tardes_cuarto, tjc.tardes_cuarto_jus, tm.tardes_media, tjm.tardes_media_jus, ap.aus_permanencia, apj.aus_permanencia_jus
ORDER BY la.tipo_curso;";
$res_inasistencias = mysql_query($sql_inasistencias);

// Armo la tabla donde muestro todos los datos.  
?>
<div>
    <table>
        <tr valign="top">
            <td align="center"><?php redimensionar($foto,200,300);?><br>
            <input type="button" value="Ver ficha del alumno" onClick="location.href='ficha_alumno.php?id=<?php echo $dni_alumno; ?>'"/>
			</td> <!-- Foto del alumno se redimensiona -->
            <td>
                <table border="0">
                    <caption class="titulo">Datos del alumno</caption>
                    <tr>
                        <td><?php echo $apellido.", ".$nombre;?></td>
                    </tr>
                    <tr>
                        <td>DNI: <?php echo $dni;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $fecha_nac;?></td>
                    </tr>
                </table>
            </td> <!-- Datos basicos del alumno --> 
            <td>
				<table border="0">
					<caption>Cursos</caption>
                    <tr>
						<th>Tipo Curso</th>
                        <th>Curso</th>
                        <th>Divisi&oacute;n</th>
                    </tr>
                    <?php
                    //Llenar la tabla
                    $row_curso = mysql_fetch_row($res_curso);
                    if ($row_curso > 0){ 
						do {
							echo "<tr>
								<td>".$row_curso[0]."</td>
								<td align='center'>".$row_curso[1]."</td>
								<td align='center'>".$row_curso[2]."</td>
							</tr>";
                        } while ($row_curso = mysql_fetch_row($res_curso));
                    }
                    ?>
                </table>
            </td> <!-- Datos del curso del alumno -->
			<td>
                <table border="1" id="asistencia" cellpadding="10">
					<caption>Asistencia</caption>
					<tr bgcolor='#FDCF89'>
						<th>Tipo Curso</th>
						<th>Presente</th>
						<th>Ausente</th>
						<th>Ausente<br>Justificado</th>
						<th>1/4 Falta</th>
						<th>1/4 Falta<br>Justificado</th>
						<th>1/2 Falta</th>
						<th>1/2 Falta<br>Justificado</th>
						<th>Ausente Permanencia</th>
						<th>Ausente Permanencia<br>Justificado</th>
					</tr>
                    <?php
                    //Llenar la tabla
					$row_inasistencias = mysql_fetch_row($res_inasistencias);
                    if ($row_inasistencias > 0){ 
						do {
							echo "<tr>
								<td><strong>".$row_inasistencias[0]."</strong></td>
								<td align='center'>".$row_inasistencias[1]."</td>
								<td align='center'>".$row_inasistencias[2]."</td>
								<td align='center'>".$row_inasistencias[3]."</td>
								<td align='center'>".$row_inasistencias[4]."</td>
								<td align='center'>".$row_inasistencias[5]."</td>
								<td align='center'>".$row_inasistencias[6]."</td>
								<td align='center'>".$row_inasistencias[7]."</td>
								<td align='center'>".$row_inasistencias[8]."</td>
								<td align='center'>".$row_inasistencias[9]."</td>
							</tr>";
                        } while ($row_inasistencias = mysql_fetch_row($res_inasistencias));
                    }
                    ?>
				</table>
			</td>
        </tr>
    </table>

<!-- Armo la tabla de calendarios escolares -->
    <table border="0">
        <tr>
            <?php
            $j=$mes_inicio; //Este es el mes donde arranca el anio lectivo.
            while ( $j <= $mes_fin ){ //Este es el mes donde finaliza el anio lectivo.
            $mess = $j;
            $anio = $anio_escolar; // Anio lectivo
            $ultimo = date("t",mktime(0, 0, 0, $mess, 1, $anio));
            $diaa = "1";
            ?>
            <td id="calendario">
                <table>
                    <tr>
                        <th colspan=7><?php echo $mess." / ".$anio; ?></th>
                    </tr>
                    <tr>
                        <td>D</td>
                        <td>L</td>
                        <td>M</td>
                        <td>M</td>
                        <td>J</td>
                        <td>V</td>
                        <td>S</td>
                    </tr>
                        <?php
                        while($diaa <= $ultimo){
                            $dia = date("D",mktime(0,0,0,$mess,$diaa,$anio)); # retorna el dia de la semana en letras...
                            $fecha = date("d",mktime(0,0,0,$mess,$diaa,$anio)); #retorna el dia del mes en 01/31
                            $dia_semana = date("w",mktime(0,0,0,$mess,$diaa,$anio)); #retorna el dia de la semana en numero    
                            if($dia == "Sun"){
                                echo "</tr><tr>";
                            }
                            if($fecha == "01"){
                                $i=0;
                                while($i != $dia_semana){
                                echo "<td>&nbsp;</td>";
                                $i++;
                                }
                            }
                            //Hago la consulta para ver si el dia que estoy mostrando el alumno estuvo ausente o tarde.
                            $inansistencia = "SELECT fecha, estado
                                            FROM `lista_alumnos` 
                                            WHERE
                                            dni = ".$dni_alumno." 
                                            AND estado <> 'P'
                                            AND extract(DAY FROM fecha) = ".$fecha."
                                            AND extract(MONTH FROM fecha) = ".$j."
                                            AND extract(YEAR FROM fecha) = ".$anio.";";
                            $res_inasis = mysql_query($inansistencia);
                            $r_ina = mysql_fetch_array($res_inasis);
                            
                            if ($r_ina["estado"]=="A" || $r_ina["estado"]=="TC" || $r_ina["estado"]=="TM" || $r_ina["estado"]=="AP"){
                                echo "<td bgcolor='#FDCF89'><a href='detalle_inasistencia.php?id=$dni_alumno&dia=$fecha&mes=$j&anio=$anio'>$fecha</a></td>";
                            } else {
                                echo "<td>$fecha</td>";
                            }
                            $diaa++;
                        }
                        echo "</tr>";
                        ?>
                </table>
            </td>
            <?php
            $j++;
            }
            ?>
        </tr>
    </table>
</div>
<?php
$conn_obj->close();
}

include_once($APP_PATH . "/includes/footer.php");
?>
