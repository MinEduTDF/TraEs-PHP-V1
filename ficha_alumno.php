<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1.2
 */
/*Con include_once llamamos a la p‡gina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Connection.php");
include_once($APP_PATH . "/Classes/Date.php");
include_once($APP_PATH . "/Classes/redimensionar.php");

/*Recibo el Id del alumno para poder asociarle una inscripci—n*/

$dni_alumno = $_GET["id"];
$fecha = new Date();

if ($dni_alumno == 0) {
    echo "No tiene seleccionado ning&uacute;n alumno";

} else {
 
//Realizar consulta SQL
    
    $conn_obj->open();

// Consulta de los datos del alumno resumidos.    
    $sql = "SELECT a.`apellido`, a.`nombre`, a.`alias`, a.`dni`, a.`foto`,
            CASE
                WHEN a.`genero` = 'M' THEN 'Masculino'
                WHEN a.`genero` = 'F' THEN 'Femenino'
            END as genero, lu.descripcion as lugar_nac, n.descripcion as nacionalidad,
            a.`fecha_nac`, a.`domicilio`, a.`telefono`, a.`mail`, a.observacion, pri.descripcion as pri_anterior, sec.descripcion as sec_anterior, a.activo
            FROM `alumnos` a
            LEFT OUTER JOIN `nacionalidad` n on n.id_nacionalidad = a.nacionalidad
            LEFT OUTER JOIN `lugar_nacimiento` lu on lu.id_lugarnacimiento = a.lugar_nac
            LEFT OUTER JOIN `primarias` pri on pri.id_primaria = a.id_primaria
            LEFT OUTER JOIN `secundarios` sec on sec.id_secundario = a.id_secundario
            WHERE a.`dni` =".$dni_alumno.";";
    $res = mysql_query($sql);
    $row = mysql_fetch_array($res);

    $apellido = $row["apellido"];
    $nombre =$row["nombre"];
    $dni = $row["dni"];
    $foto = $row["foto"];
    $lugar_nacimiento = $row["lugar_nac"];
    $nacionalidad = $row["nacionalidad"];
    $fecha_nac = $fecha ->sql2form($row["fecha_nac"]);
    $genero = $row["genero"];
        
    $domicilio = $row["domicilio"];
    $tel = $row["telefono"];
    $mail = $row["mail"];
    $observacion = $row["observacion"];
    $sec_anterior = $row["sec_anterior"];
    $pri_anterior = $row["pri_anterior"];
    $estado_activo = $row["activo"];

// Consulta del curso donde se inscribio el alumno
    $sql_curso = "SELECT tc.descripcion as tipocurso, c.descripcion as curso, d.descripcion as division
            FROM `cursos_alumnos` ca 
            LEFT OUTER JOIN `cursos` c ON c.`id_curso` = ca.`id_curso`
            LEFT OUTER JOIN `divisiones` d ON d.`id_division` = ca.`id_division`
            LEFT OUTER JOIN `tipo_curso` tc ON tc.`id_tipocurso` = ca.`id_tipocurso` 
            WHERE ca.dni =".$dni_alumno." and (ca.fecha_hasta is NULL or ca.fecha_hasta = '')
            ORDER BY ca.id_tipocurso;";
    $res_curso = mysql_query($sql_curso);
// Armo la tabla donde muestro todos los datos.  
?>
<div>
    <table>
        <tr valign="top">
            <td><?php redimensionar($foto,200,300);?></td> <!-- Foto del alumno se redimensiona -->
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
                        <td><?php echo $genero;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $lugar_nacimiento;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $nacionalidad;?></td>
                    </tr>    
                    <tr>
                        <td><?php echo $fecha_nac;?></td>
                    </tr>
                </table>
            </td> <!-- Datos b‡sicos del alumno -->
            <td>
                <table border="0">
                    <caption>Contacto</caption>
                    <tr>
                        <td><?php echo $domicilio;?></td>
                    </tr>
                    <tr>
                        <td>Tel&eacute;fono: <?php echo $tel;?></td>
                    </tr>
                    <tr>
                        <td>Mail: <?php echo $mail;?></td>
                    </tr>
                    <tr>
                        <td>Observaci&oacute;n: <?php echo $observacion;?></td>
                    </tr>
                    <tr>
                        <td>Primaria: <?php echo $pri_anterior; ?></td>
                    </tr>
                    <tr>
                        <td>Secundario Anterior: <?php echo $sec_anterior; ?></td>
                    </tr>
                </table>
            </td> <!-- Datos de contacto del alumno -->
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
        </tr>
    </table>
</div>
<br>
<br>
<?php 
if ($estado_activo == 0) { 
	if ($_SESSION["nivel"]==1 || $_SESSION["nivel"]==4){ ?>
		<div>
			<form action="ficha_alumno.php?id=<?php echo $dni; ?>" method="post" enctype="multipart/form-data">
				<label for="agregar_foto">Modificar Foto: </label><input name="foto" type="file" />
				<input type="submit" value="Guardar foto">
				<input type="hidden" name="cmd2" value="carga_foto"/>
				<input type="hidden" name="dni_alumno" value= "<?php echo $dni; ?>"/> 
			</form> <!-- Formulario para cargar una foto en el alumno -->
			
			<input type="button" value="Modificar datos del alumno" onClick="location.href='modificar_alumno.php?id=<?php echo $dni; ?>'"/>
			<!-- Bot—n para modificar los datos del alumno. Lleva a una p‡gina nueva. -->
		</div>
	<?php } //Cierra if que controla Nivel del Usuario para poder modificar datos del alumno o del curso ?>
	<input type="button" value="Cambiar curso/Ver Hist&oacute;rico de Cursos" onClick="location.href='inscripcion_curso.php?dni=<?php echo $dni; ?>'"/>
	<!-- Bot—n para modificar el turno, curso o divisi—n del alumno o ver el hist—rico de cambios. Lleva a una p‡gina nueva.-->
<?php	
	if ($_SESSION["nivel"]==1 || $_SESSION["nivel"]==2 || $_SESSION["nivel"]==3){ ?>
		<div>
			<input type="button" value="Agregar/Ver Intervenciones" onClick="location.href='intervencion.php?dni=<?php echo $dni; ?>'"/>
		</div><!-- Bot—n para ver o agregar una nueva intervenci—n. Lleva a una p‡gina nueva.-->
	<?php } //Cierra if que controla Nivel del Usuario para poder cargar una intervencion o ver las intervenciones ?>
	<div>
		<input type="button" value="Informe de Inasistencias" onClick="location.href='asistencia_alumno.php?id=<?php echo $dni; ?>'"/>
	</div><!-- Bot—n para ver el Informe por alumno de inasistencia y poder justificar las faltas. Lleva a una p‡gina nueva. -->
<?php
} //Cierra if de alumno activo
$conn_obj->close();
} //Cierra if que comprueba que la dirección tengo un DNI

echo @$inscripto;
echo @$error;

include_once($APP_PATH . "/includes/footer.php");
?>
