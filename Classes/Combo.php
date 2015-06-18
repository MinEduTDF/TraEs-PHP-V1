<?php
/**
 * @author Victoria Marino
 * @package Classes
 * @version 1.1
 */
include_once($APP_PATH . "/Classes/Connection.php");

//  instancia los objetos
$conn_obj = new Connection();

$conn_obj->open();

// Consulta de Nacionalidad
$nac_mysql = "select id_nacionalidad, descripcion from nacionalidad order by descripcion";
$combo_nacionalidad= mysql_query($nac_mysql);

//Consulta de Lugar Nacimiento
$lug_mysql = "select id_lugarnacimiento, descripcion from lugar_nacimiento order by descripcion";
$combo_lugarnac = mysql_query($lug_mysql);

// Consulta de Turnos
$t_mysql = "select id_turno, descripcion from turnos where activo = 0 order by id_turno";
$combo_turno= mysql_query($t_mysql);

// Consulta de Tipo de curso
$tc_mysql = "select id_tipocurso, descripcion, op_nocursa from tipo_curso where activo = 0 order by id_tipocurso";
$combo_tipocurso= mysql_query($tc_mysql);

// Consulta de Cursos
$c_mysql = "select id_curso, descripcion, turno from cursos where activo = 0 order by id_curso";
$combo_curso= mysql_query($c_mysql);

// Consulta de Divisiones
$d_mysql = "select id_division, descripcion from divisiones where activo = 0 order by id_division";
$combo_division= mysql_query($d_mysql);

//Consulta de Escuelas Primarias
$p_mysql = "select id_primaria, descripcion from primarias where activo = 0 order by descripcion";
$combo_primaria= mysql_query($p_mysql);

//Consulta de Colegios Secundarios
$s_mysql = "select id_secundario, descripcion from secundarios where activo = 0 order by id_secundario";
$combo_secundario= mysql_query($s_mysql);

//Consulta de Usuarios
$u_mysql = "select id_usuario, nombre_usuario, nombre, mail, fecha_nac, nivel, activo from usuarios order by nombre";
$combo_usuario= mysql_query($u_mysql);



?>
