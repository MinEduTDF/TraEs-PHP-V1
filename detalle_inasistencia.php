<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 2
 */
//Con include_once llamamos a la pagina de referencia y la mostramos
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");

$row = mysql_fetch_array($res);

?>

<h2>Novedades del d&iacute;a <?php echo $dia."/".$mes."/".$anio; ?></h2>
<h3>Alumno: <?php echo $row["apellido"]." ".$row["nombre"]; ?></h3>
<table>
    <tr>
        <th>Curso</th>
        <th>Estado</th>
        <th>Justificado</th>
        <th>Observaci&oacute;n</th>
        <th>Justificar</th>
    </tr>
<?php

if ($row > 0){ 
    do { 
        ?><tr>
			<td><?php echo $row["tipo_curso"]; ?></td>
			<td><?php echo $row["estado"]; ?></td>
			<td align='center'><?php echo ($row["justificado"]==1)? "OK" : ""; ?></td>
			<td><?php echo $row["observacion"]; ?></td>
			<?php if($row["justificado"]==1) {
						echo "<td align='center'><a href='#'><img src='imgs/justificar.png' alt='Justificar'></a></td></tr>";
			} else {
				echo "<td align='center'><a href='justificar.php?id=".$row['id']."'><img src='imgs/modificar.png' alt='Justificado'></a></td></tr>";
			}
		} while ($row = mysql_fetch_array($res));
}
?>

</table><br><br>

<input type="button" value="Volver" onClick="location.href='asistencia_alumno.php?id=<?php echo $dni; ?>'"/>
<br><!-- Boton para ver el Informe por alumno de inasistencia y poder justificar las faltas. Lleva a una pagina nueva. -->

<?php

include_once($APP_PATH . "/includes/footer.php");
?>
