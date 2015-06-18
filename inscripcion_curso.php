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
include_once($APP_PATH . "/Classes/Combo.php");

/*Recibo el DNI del alumno*/

$dni_alumno = @$_GET["dni"];
$fecha = new Date();

if ($dni_alumno == 0) {
    echo "No tiene seleccionado ning&uacute;n alumno";

} else {
 
//Realizar consulta SQL
    
    $conn_obj->open();

// Consulta de los datos del alumno resumidos.    
    $sql = "SELECT a.`nombre`, a.`apellido`, a.`dni`, a.`foto`, a.`fecha_nac`, a.`observacion`
            FROM `alumnos` a
            WHERE a.`dni` =".$dni_alumno." AND a.`activo` = 0;";
    $res = mysql_query($sql);
    $row = mysql_fetch_array($res);

    $nombre =$row["nombre"]." ".$row["apellido"];
    $dni = $row["dni"];
    $foto = $row["foto"];
    $fecha_nac = $fecha ->sql2form($row["fecha_nac"]);
    $observacion = $row["observacion"];

// Consulta de los cursos en los que fue inscripto el alumno
    $sql_p = "SELECT tc.descripcion as tipocurso, c.descripcion as curso, d.descripcion as division, ca.fecha_desde, ca.fecha_hasta, u.nombre as usuario, ca.id, ub.nombre as usuario_baja
            FROM `cursos_alumnos` ca
            LEFT OUTER JOIN `tipo_curso` tc ON tc.`id_tipocurso` = ca.`id_tipocurso`
            LEFT OUTER JOIN `cursos` c ON c.`id_curso` = ca.`id_curso`
            LEFT OUTER JOIN `divisiones` d ON d.`id_division` = ca.`id_division`
            LEFT OUTER JOIN `usuarios` u ON u.`nombre_usuario` = ca.`usuario`
            LEFT OUTER JOIN `usuarios` ub ON ub.`nombre_usuario` = ca.`usuario_baja`
            WHERE ca.`dni` =".$dni_alumno." ORDER BY ca.`fecha_desde` desc;";
    $res_p = mysql_query($sql_p);

// Armo la tabla donde muestro todos los datos.  
?>
<div>
    <table>
        <tr valign="top">
            <td><?php redimensionar($foto,200,300);?></td> <!-- Foto del alumno -->
            <td>
                <table border="0">
                    <caption class="titulo">Datos del alumno</caption>
                    <tr>
                        <td><?php echo $nombre;?></td>
                    </tr>
                    <tr>
                        <td>DNI: <?php echo $dni;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $fecha_nac;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $observacion;?></td>
                    </tr>
                </table>
            </td> <!-- Datos b‡sicos del alumno -->
            <td>
                <table border="1" cellpadding="6" rules="cols">
                    <caption>Hist&oacute;rico Cursos</caption>
                    <tr>
						<th>Tipo Curso</th>
                        <th>Curso</th>
                        <th>Divisi&oacute;n</th>
                        <th>Fecha Desde</th>
                        <th>Fecha Hasta</th>
                        <th>Usuario</th>
                        <th>Dar Baja</th>
                    </tr>
                    <?php
                        //Llenar la tabla
                        $row_p = mysql_fetch_row($res_p);
                        if ($row_p > 0){ 
                            do {
								if($_SESSION["nivel"]==1 || $_SESSION["nivel"]==4){
									$baja = "<a href='baja_curso.php?id=".$row_p[6]."&dni=".$dni_alumno."'><img src='imgs/borrar.png' alt='Baja'></a>";
								}
                                if ($row_p[4]>0){
									$baja = "";
								}
								if ($row_p[7]==""){
									$usu = $row_p[5];
								} else {
									$usu = $row_p[7];
								}
                                echo "<tr>
                                        <td>".$row_p[0]."</td>
                                        <td align='center'>".$row_p[1]."</td>
                                        <td align='center'>".$row_p[2]."</td>
                                        <td>".$fecha ->sql2form($row_p[3])."</td>
                                        <td>".$fecha ->sql2form($row_p[4])."</td>
                                        <td>".$usu."</td>
                                        <td align='center'>".$baja."</td>
                                    </tr>";
                            } while ($row_p = mysql_fetch_row($res_p));
                        }            
                    ?>
                </table>
            </td> <!-- Datos de las inscripciones en los Cursos Historico -->
        </tr>
    </table>
</div>
<br>
<br>
<?php if($_SESSION["nivel"]==1 || $_SESSION["nivel"]==4){ ?>

<div>
    <form action="inscripcion_curso.php?dni=<?php echo $dni; ?>" method="post">
        <label for="tipocurso">Tipo Curso: </label><select name="tipocurso">
        <?php
        //Llenar el combo
        if ($row_t = mysql_fetch_array($combo_tipocurso)){ 
            do { 
                echo '<option value= "'.$row_t["id_tipocurso"].'">'.$row_t["descripcion"].'</option>';
            } while ($row_t = mysql_fetch_array($combo_tipocurso));
        }
        ?>
        </select><br/>
        <label for="curso">Curso: </label><select name="curso">
        <?php
        //Llenar el combo
        if ($row_c = mysql_fetch_array($combo_curso)){ 
            do { 
                echo '<option value= "'.$row_c["id_curso"].'">'.$row_c["descripcion"].'</option>';
            } while ($row_c = mysql_fetch_array($combo_curso));
        }        
        ?>
        </select><br/>
        <label for="division">Divisi&oacute;n: </label><select name="division">
        <?php
        //Llenar el combo
        if ($row_d = mysql_fetch_array($combo_division)){ 
            do { 
                echo '<option value= "'.$row_d["id_division"].'">'.$row_d["descripcion"].'</option>';
            } while ($row_d = mysql_fetch_array($combo_division));
        }        
        ?>
        </select><br/>
        <br/>
        <input type="submit" value="Confirmar" /><br>
        <input type="hidden" name="cmd" value="confirmar"/><br>
        <input type="hidden" name="fecha" value="<?php echo date("Ymd"); ?>"/><br>
        <input type="hidden" name="dni_alumno" value= "<?php echo $dni_alumno; ?>"/><br>
    </form> <!-- Formulario para inscribir al alumno a un nuevo curso -->
</div>
<?php
	$conn_obj->close();
	} else {
		echo "No tiene autorizaci&oacute;n para cambiar de Curso a un Alumno";
	}

} //Cierra el if de control que tenga la variable DNI
echo @$inscripto;
?>
<br><br>
<input type="button" value="Ver ficha del alumno" onClick="location.href='ficha_alumno.php?id=<?php echo $dni; ?>'"/>

<?php
include_once($APP_PATH . "/includes/footer.php");
?>
