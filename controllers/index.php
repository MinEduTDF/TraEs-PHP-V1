<?php
/**
 * @author Victoria Marino
 * @package controllers
 * @version 1.2
 */
//Con include_once llamamos a la p‡gina de referencia y la mostramos
include_once(dirname(__FILE__) . "/../includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/Classes/Connection.php");

//  instancia los objetos
$conn_obj = new Connection();

//  abre la conexion
$conn_obj->open();

// Busco los alumnos que cumplen a–os en el d’a de la fecha
    $sql = "SELECT a.dni, a.nombre, a.apellido, a.fecha_nac, t.descripcion as turno, c.descripcion as curso, d.descripcion as division FROM `alumnos` a
            LEFT OUTER JOIN `alumnos_cursos` ac ON ac.`id_alumno_curso` = a.`id_alumno_curso`
            LEFT OUTER JOIN `turnos` t ON t.`id_turno` = ac.`id_turno`
            LEFT OUTER JOIN `cursos` c ON c.`id_curso` = ac.`id_curso`
            LEFT OUTER JOIN `divisiones` d ON d.`id_division` = ac.`id_division`
            WHERE extract(DAY FROM `fecha_nac`) = ".date("j")."
            AND extract(MONTH FROM `fecha_nac`) = ".date("m").";";
    $res = mysql_query($sql);
    $row = mysql_num_rows($res);

    if( $row > 0 )
    {
        $ellos = "";
        while($rs = mysql_fetch_array($res))
            {
            $ellos = $ellos.$rs["nombre"]." ".$rs["apellido"]." | ".$rs["turno"]." ".$rs["curso"]." ".$rs["division"]."<br>";
            }
        $cumple = "Hoy es el cumplea&#241;os de estos chicos: <br><br>".$ellos;
    } else {
        $cumple = "No hay cumplea&#241;os de chicos hoy ".date("d/m/Y");
    }

// Busco los usuarios que cumplen a–os en el d’a de la fecha
    $sql_usu = "SELECT u.nombre_usuario, u.nombre FROM `usuarios` u
            WHERE extract(DAY FROM `fecha_nac`) = ".date("j")."
            AND extract(MONTH FROM `fecha_nac`) = ".date("m").";";
    $res_usu = mysql_query($sql_usu);
    $row_usu = mysql_num_rows($res_usu);

    if( $row_usu > 0 )
    {
        $ellos_usu = "";
        while($rs_usu = mysql_fetch_array($res_usu))
            {
            $ellos_usu = $ellos_usu.$rs_usu["nombre"]."<br>";
            }
        $cumple_usu = "Y estos profes/preceptores festejan hoy: <br><br>".$ellos_usu;
    } 

//Busco las novedades del d’a de la fecha
    $sql_nov = "SELECT n.`titulo`, n.`texto`, u.`nombre` FROM `novedades` n
                INNER JOIN `usuarios` u ON u.`nombre_usuario` = n.`usuario`
                WHERE
                n.`fecha_desde` = '".date("Ymd")."' 
                OR 
                (n.`fecha_desde` < '".date("Ymd")."' AND n.`fecha_hasta` > '".date("Ymd")."')
                OR
                n.`fecha_hasta` = '".date("Ymd")."';";
    $res_nov = mysql_query($sql_nov);
    $row_nov = mysql_num_rows($res_nov);
    
    if( $row_nov > 0 )
    {
        while ($rs_nov = mysql_fetch_array($res_nov))
        {
            $novedad = $novedad.$rs_nov["texto"]." (".$rs_nov["nombre"].")<br>";
        }
        $novedades = $novedad;
    } else {
        $novedades = "No hay novedades hoy ".date("d/m/Y");
    }
    


//  cierra la conexion
$conn_obj->close();

?>
