<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1.0
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
    $sql = "SELECT a.`nombre`, a.`apellido`, a.`dni`, a.`foto`,
            CASE
                WHEN a.`genero` = 'M' THEN 'Masculino'
                WHEN a.`genero` = 'F' THEN 'Femenino'
            END as genero, a.`fecha_nac`, a.`observacion`, a.`id_alumno_curso`
            FROM `alumnos` a
            WHERE a.`dni` =".$dni_alumno." AND a.`activo` = 0;";
    $res = mysql_query($sql);
    $row = mysql_fetch_array($res);

    $nombre =$row["nombre"]." ".$row["apellido"];
    $dni = $row["dni"];
    $foto = $row["foto"];
    $genero = $row["genero"];
    $fecha_nac = $fecha ->sql2form($row["fecha_nac"]);
    $observacion = $row["observacion"];

// Consulta de las intervenciones realizadas al alumno
    $sql_p = "SELECT i.fecha, i.titulo, ic.texto, u.nombre as usuario, i.id_intervencion
            FROM `intervencion_cabecera` i
            LEFT OUTER JOIN `intervencion_cuerpo` ic on ic.`id_intervencion` = i.`id_intervencion`
            LEFT OUTER JOIN `usuarios` u on u.`nombre_usuario` = i.`usuario`
            WHERE i.`dni_alumno` =".$dni_alumno." and (i.activo = 0 or i.activo is null) ORDER BY i.`fecha`;";
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
                        <td><?php echo $genero;?></td>
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
                    <tr><th>Titulo</th>
                        <th>Texto</th>
                        <th>Fecha</th>
                        <th>Usuario</th>  
                        <th>Borrar</th>                      
                    </tr>
                    <?php
                        //Llenar la tabla
                        $row_p = mysql_fetch_row($res_p);
                        
                        if ($row_p > 0){ 
                            do {
                                echo "<tr>
                                        <td>".$row_p[1]."</td>
                                        <td>".$row_p[2]."</td>
                                        <td>".$fecha ->sql2form($row_p[0])."</td>
                                        <td>".$row_p[3]."</td>
                                        <td align='center'><a href='borrar_intervencion.php?id=".$row_p[4]."&dni=".$dni."'><img src='imgs/borrar.png' alt='Borrar'></a></td>
                                    </tr>";
                            } while ($row_p = mysql_fetch_row($res_p));
                        }            
                    ?>
                </table>
            </td> <!-- Datos de las intervenciones -->
        </tr>
    </table>
</div>
<br>
<br>
<div>
    <form action="intervencion.php?dni=<?php echo $dni; ?>" method="post">
        <label for="titulo">Titulo: </label><input type="text" name="titulo" /><br/>
        <label for="texto">Texto: </label><textarea name="texto" rows=5 cols=50></textarea><br/>
        <input type="submit" value="Confirmar" /><br>
        <input type="hidden" name="cmd" value="confirmar"/><br>
        <input type="hidden" name="fecha" value="<?php echo date("Ymd"); ?>"/><br>
        <input type="hidden" name="dni_alumno" value= "<?php echo $dni_alumno; ?>"/><br>
    </form> <!-- Formulario para cargar una intervencion nueva -->
</div>

<input type="button" value="Ver ficha del alumno" onClick="location.href='ficha_alumno.php?id=<?php echo $dni; ?>'"/>
<br><br>

<?php

$conn_obj->close();
}

echo @$intervencion;
include_once($APP_PATH . "/includes/footer.php");

?>
