<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1.2
 */
//Con include_once llamamos a la p‡gina de referencia y la mostramos
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Connection.php");

//  instancia los objetos
$conn_obj = new Connection();

//Traigo los datos con el mŽtdo POST para que no se vean en la barra URL
$apellido = $_GET["apellido"];

?>

<h2>Alumnos</h2>

<br>
<table align="center">

<?php
//  abre la conexion
$conn_obj->open();

//Llamo el SP para buscar alumnos por apellido o dni pero solo paso el parametro de apellido.

    $sql = "CALL buscar_alumno('".$apellido."%', 0);";
    $res = mysql_query($sql);
    $row = mysql_num_rows($res);

//Armo una tabla con los resultados donde muestros los datos b‡sicos y los iconos para ver la foto o ir a la ficha del alumno.
    if( $row > 0 )
    {
        while($rs = mysql_fetch_array($res))
        {
            ?>
            <tr><td><a href="#" onClick="afoto('<?php echo $rs["foto"]; ?>');return false"><img src="imgs/foto.png"></a></td>
            <td><?php echo $rs["apellido"].", ".$rs["nombre"]; ?></td>
            <td><?php echo $rs["dni"]; ?></td>
            <td><a href="ficha_alumno.php?id=<?php echo $rs["dni"]; ?>"><img src="imgs/ficha.png"></a></td></tr>
            <?php
        }
    }
    else
    {
        ?>
        <tr><td>No se encontro ningun alumno con esos datos</td></tr>
        <?php 
    }

    mysql_free_result($res);

//  cierra la conexion
$conn_obj->close();
?>
</table>
<br>
<div align=center>
    <input type="button" value="Buscar otro alumno" onClick="location.href='buscar_alumno.php'"/>
</div>

<?php

include_once($APP_PATH . "/includes/footer.php"); 

?>
