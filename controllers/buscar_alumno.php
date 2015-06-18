<?php
/**
 * @author Victoria Marino
 * @package controllers
 * @version 1.2
 */
//Con include_once llamamos a la p‡gina de referencia y la mostramos
include_once(dirname(__FILE__) . "/../includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
include_once($APP_PATH . "/Classes/Connection.php");


//Traigo los datos con el mŽtdo POST para que no se vean en la barra URL
$apellido = @$_POST["apellido"];
$dni = @$_POST["dni"];
$cmd = @$_POST["cmd"];

if( $cmd == "buscar" ) {
    if( $dni == 0 ) {
        //Si el dni viene en 0 asume que tiene que buscar por apellido y lo direcciona a el listado de alumnos por apellido.
        header("location:listado.php?apellido=".$apellido);
        exit;
    } else {
        //  instancia los objetos
        $conn_obj = new Connection();
        //  abre la conexion
        $conn_obj->open();
        //Busco primero si existe algœn alumno con ese DNI, si existe lo direcciono a la ficha del alumno.
        $select_dni = "SELECT `dni` FROM `alumnos` WHERE `dni` = ".$dni.";";
        $res_dni = mysql_query($select_dni);
        $rs_dni = mysql_fetch_assoc($res_dni);
            if ($rs_dni > 0){ 
                header("location:ficha_alumno.php?id=".$dni);
            } else {
                $error = "No se encuentra alumno con el DNI: ".$dni;
            }
    }
}
?>