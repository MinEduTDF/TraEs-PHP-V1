<?php
/**
 * @author Victoria Marino
 * @package controllers
 * @version 1.2
 */
/*Con include_once llamamos a la p‡gina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/../includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/Classes/Connection.php");

//  instancia los objetos
$conn_obj = new Connection();

//  abre la conexion
$conn_obj->open();

//Consulta de 3 inasistencias
$sql3 = "SELECT la.dni, a.apellido, a.nombre, t.descripcion as turno, c.descripcion as curso, d.descripcion as division
        FROM `lista_alumnos` la 
        INNER JOIN 
        (SELECT dni, count(*) AS ausentes FROM `lista_alumnos` 
        WHERE estado = 'A' AND (justificado = 0 OR justificado IS NULL) AND extract(YEAR FROM fecha) = ".date("Y")." AND extract(MONTH FROM fecha) = ".date("m")."
        GROUP BY dni) b ON la.dni = b.dni
        INNER JOIN `alumnos` a ON a.dni = la.dni
        LEFT OUTER JOIN `alumnos_cursos` ac ON ac.id_alumno_curso = a.id_alumno_curso
        LEFT OUTER JOIN `turnos` t ON t.id_turno = ac.id_turno
        LEFT OUTER JOIN `cursos` c ON c.id_curso = ac.id_curso
        LEFT OUTER JOIN `divisiones` d ON d.id_division = ac.id_division
        WHERE `estado` = 'A' AND (`justificado` = 0 OR `justificado` IS NULL)
        AND b.ausentes > 2 AND b.ausentes < 5
        GROUP BY la.dni, a.apellido, a.nombre, t.descripcion, c.descripcion, d.descripcion
        ORDER BY t.descripcion, c.descripcion, d.descripcion, a.apellido;";
$res3 = mysql_query($sql3);
$row3 = mysql_num_rows($res3);

if( $row3 > 0) {
    while ( $r3 = mysql_fetch_array($res3) ) {
        $faltas3 = $faltas3."<a href='asistencia_alumno.php?id=".$r3["dni"]."'><img src='imgs/btn_mas_info.png' alt='Ver inasistencias hist&oacute;ricas'></a> ".$r3["turno"]." ".$r3["curso"]." ".$r3["division"]." | ".$r3["apellido"]." ".$r3["nombre"]."<br>";
    } 
} else {
    $faltas3 = "<font color='#B0B0B1'>No hay alumnos con 3 faltas en el mes actual</font>";
}

//Consulta de 5 inasistencias
$sql5 = "SELECT la.dni, a.apellido, a.nombre, t.descripcion as turno, c.descripcion as curso, d.descripcion as division
        FROM `lista_alumnos` la 
        INNER JOIN 
        (SELECT dni, count(*) AS ausentes FROM `lista_alumnos` 
        WHERE estado = 'A' AND (justificado = 0 OR justificado IS NULL) AND extract(YEAR FROM fecha) = ".date("Y")." AND extract(MONTH FROM fecha) = ".date("m")."
        GROUP BY dni) b ON la.dni = b.dni
        INNER JOIN `alumnos` a ON a.dni = la.dni
        LEFT OUTER JOIN `alumnos_cursos` ac ON ac.id_alumno_curso = a.id_alumno_curso
        LEFT OUTER JOIN `turnos` t ON t.id_turno = ac.id_turno
        LEFT OUTER JOIN `cursos` c ON c.id_curso = ac.id_curso
        LEFT OUTER JOIN `divisiones` d ON d.id_division = ac.id_division
        WHERE `estado` = 'A' AND (`justificado` = 0 OR `justificado` IS NULL)
        AND b.ausentes > 4 AND b.ausentes < 15
        GROUP BY la.dni, a.apellido, a.nombre, t.descripcion, c.descripcion, d.descripcion
        ORDER BY t.descripcion, c.descripcion, d.descripcion, a.apellido;";
$res5 = mysql_query($sql5);
$row5 = mysql_num_rows($res5);

if( $row5 > 0) {
    while ( $r5 = mysql_fetch_array($res5) ) {
        $faltas5 = $faltas5."<a href='asistencia_alumno.php?id=".$r3["dni"]."'><img src='imgs/btn_mas_info.png' alt='Ver inasistencias hist&oacute;ricas'></a>  ".$r5["turno"]." ".$r5["curso"]." ".$r5["division"]." | ".$r5["apellido"]." ".$r5["nombre"]."<br>";
    }
} else {
    $faltas5 = "<font color='#B0B0B1'>No hay alumnos con 5 faltas en el mes actual</font>";
}

//Consulta de 15 inasistencias
$sql15 = "SELECT la.dni, a.apellido, a.nombre, t.descripcion as turno, c.descripcion as curso, d.descripcion as division
        FROM `lista_alumnos` la 
        INNER JOIN 
        (SELECT dni, count(*) AS ausentes FROM `lista_alumnos` 
        WHERE estado = 'A' AND (justificado = 0 OR justificado IS NULL) AND extract(YEAR FROM fecha) = ".date("Y")."
        GROUP BY dni) b ON la.dni = b.dni
        INNER JOIN `alumnos` a ON a.dni = la.dni
        LEFT OUTER JOIN `alumnos_cursos` ac ON ac.id_alumno_curso = a.id_alumno_curso
        LEFT OUTER JOIN `turnos` t ON t.id_turno = ac.id_turno
        LEFT OUTER JOIN `cursos` c ON c.id_curso = ac.id_curso
        LEFT OUTER JOIN `divisiones` d ON d.id_division = ac.id_division
        WHERE `estado` = 'A' AND (`justificado` = 0 OR `justificado` IS NULL)
        AND b.ausentes > 14 AND b.ausentes < 23
        GROUP BY la.dni, a.apellido, a.nombre, t.descripcion, c.descripcion, d.descripcion
        ORDER BY t.descripcion, c.descripcion, d.descripcion, a.apellido;";
$res15 = mysql_query($sql15);
$row15 = mysql_num_rows($res15);

if( $row15 > 0) {
    while ( $r15 = mysql_fetch_array($res15) ) {
        $faltas15 = $faltas15."<a href='asistencia_alumno.php?id=".$r3["dni"]."'><img src='imgs/btn_mas_info.png' alt='Ver inasistencias hist&oacute;ricas'></a>  ".$r15["turno"]." ".$r15["curso"]." ".$r15["division"]." | ".$r15["apellido"]." ".$r15["nombre"]."<br>";
    }
} else {
    $faltas15 = "<font color='#B0B0B1'>No hay alumnos con 15 faltas</font>";
}

//Consulta de 23 inasistencias
$sql23 = "SELECT la.dni, a.apellido, a.nombre, t.descripcion as turno, c.descripcion as curso, d.descripcion as division
        FROM `lista_alumnos` la 
        INNER JOIN 
        (SELECT dni, count(*) AS ausentes FROM `lista_alumnos` 
        WHERE estado = 'A' AND (justificado = 0 OR justificado IS NULL) AND extract(YEAR FROM fecha) = ".date("Y")."
        GROUP BY dni) b ON la.dni = b.dni
        INNER JOIN `alumnos` a ON a.dni = la.dni
        LEFT OUTER JOIN `alumnos_cursos` ac ON ac.id_alumno_curso = a.id_alumno_curso
        LEFT OUTER JOIN `turnos` t ON t.id_turno = ac.id_turno
        LEFT OUTER JOIN `cursos` c ON c.id_curso = ac.id_curso
        LEFT OUTER JOIN `divisiones` d ON d.id_division = ac.id_division
        WHERE `estado` = 'A' AND (`justificado` = 0 OR `justificado` IS NULL)
        AND b.ausentes > 22 AND b.ausentes < 25
        GROUP BY la.dni, a.apellido, a.nombre, t.descripcion, c.descripcion, d.descripcion
        ORDER BY t.descripcion, c.descripcion, d.descripcion, a.apellido;";
$res23 = mysql_query($sql23);
$row23 = mysql_num_rows($res23);

if( $row23 > 0) {
    while ( $r23 = mysql_fetch_array($res23) ) {
        $faltas23 = $faltas23."<a href='asistencia_alumno.php?id=".$r3["dni"]."'><img src='imgs/btn_mas_info.png' alt='Ver inasistencias hist&oacute;ricas'></a>  ".$r23["turno"]." ".$r23["curso"]." ".$r23["division"]." | ".$r23["apellido"]." ".$r23["nombre"]."<br>";
    }
} else {
    $faltas23 = "<font color='#B0B0B1'>No hay alumnos con 23 faltas</font>";
}

//Consulta de 25 inasistencias
$sql25 = "SELECT la.dni, a.apellido, a.nombre, t.descripcion as turno, c.descripcion as curso, d.descripcion as division
        FROM `lista_alumnos` la 
        INNER JOIN 
        (SELECT dni, count(*) AS ausentes FROM `lista_alumnos` 
        WHERE estado = 'A' AND (justificado = 0 OR justificado IS NULL) AND extract(YEAR FROM fecha) = ".date("Y")."
        GROUP BY dni) b ON la.dni = b.dni
        INNER JOIN `alumnos` a ON a.dni = la.dni
        LEFT OUTER JOIN `alumnos_cursos` ac ON ac.id_alumno_curso = a.id_alumno_curso
        LEFT OUTER JOIN `turnos` t ON t.id_turno = ac.id_turno
        LEFT OUTER JOIN `cursos` c ON c.id_curso = ac.id_curso
        LEFT OUTER JOIN `divisiones` d ON d.id_division = ac.id_division
        WHERE `estado` = 'A' AND (`justificado` = 0 OR `justificado` IS NULL)
        AND b.ausentes > 24
        GROUP BY la.dni, a.apellido, a.nombre, t.descripcion, c.descripcion, d.descripcion
        ORDER BY t.descripcion, c.descripcion, d.descripcion, a.apellido;";
$res25 = mysql_query($sql25);
$row25 = mysql_num_rows($res25);

if( $row25 > 0) {
    while ( $r25 = mysql_fetch_array($res25) ) {
        $faltas25 = $faltas25."<a href='asistencia_alumno.php?id=".$r3["dni"]."'><img src='imgs/btn_mas_info.png' alt='Ver inasistencias hist&oacute;ricas'></a>  ".$r25["turno"]." ".$r25["curso"]." ".$r25["division"]." | ".$r25["apellido"]." ".$r25["nombre"]."<br>";
    }
} else {
    $faltas25 = "<font color='#B0B0B1'>No hay alumnos con 25 faltas</font>";
}
//  cierra la conexion
$conn_obj->close();

?>