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
include_once($APP_PATH . "/Classes/Date.php");

//  instancia los objetos
$conn_obj = new Connection();
$fecha = new Date();

//Traigo el dato para buscar el alumno para modificar.
$dni = @$_POST["dni"];
$cmd1 = @$_POST["cmd1"];

if( $cmd1 == "buscar") {
    if( $dni == ""){
        $alerta = "<font color='red'>Debe escribir el <strong>n&uacute;mero de DNI</strong> del Alumno del que desea modificar los datos. </font><br><br>";
    } else {
    
    //  abre la conexion
    $conn_obj->open();
    
    $alumno = "SELECT apellido, nombre, alias, genero, domicilio, telefono, mail, fecha_nac, lugar_nac, nacionalidad, observacion, id_primaria, id_secundario, auto_medico, auto_salida from alumnos where dni = ".$dni." AND activo = 0;";
    $res_alumno = mysql_query($alumno);
    $rs_alumno = mysql_fetch_assoc($res_alumno);
    $ape_alumno = $rs_alumno["apellido"];
    $nom_alumno = $rs_alumno["nombre"];
    $alias_alumno = $rs_alumno["alias"];
    $gen_alumno = $rs_alumno["genero"];
    $dom_alumno = $rs_alumno["domicilio"];
    $tel_alumno = $rs_alumno["telefono"];
    $mail_alumno = $rs_alumno["mail"];
    $fech_alumno = $fecha ->sql2form($rs_alumno["fecha_nac"]);
    $lugar_alumno = $rs_alumno["lugar_nac"];
    $nacionalidad_alumno = $rs_alumno["nacionalidad"];
    $obs_alumno = $rs_alumno["observacion"];
    $secundario_alumno = $rs_alumno["id_secundario"];
    $primaria_alumno = $rs_alumno["id_primaria"];
    $medico_alumno = $rs_alumno["auto_medico"];
    $salida_alumno = $rs_alumno["auto_salida"];

    
    //  cierra la conexion
    $conn_obj->close();
    }
}

//Traigo los datos con el mŽtdo POST para que no se vean en la barra URL
$apellido = @$_POST["apellido"];
$nombre = @$_POST["nombre"];
$alias = @$_POST["alias"];
$lugar_nacimiento = @$_POST["lugar_nacimiento"];
$nacionalidad = @$_POST["nacionalidad"];
$fecha_nac = @$fecha ->form2sql($_POST["fecha_nac"]);
$domicilio = @$_POST["domicilio"];
$telefono = @$_POST["telefono"];
$mail = @$_POST["mail"];
$genero = @$_POST["genero"];
$observacion = @$_POST["observaciones"];
$secundario = @$_POST["secundario"];
$primaria = @$_POST["primaria"];
$auto_medico = (@$_POST["auto_medico"] == 1) ? 1 : 0;
$auto_salida = (@$_POST["auto_salida"] == 1) ? 1 : 0;
$cmd2 = @$_POST["cmd2"];

if( $cmd2 == "modificar" ) {

//  abre la conexion
$conn_obj->open();
    
//Llamo el SP para agregar un alumno que tengo en la BD

    $modificar = "UPDATE alumnos SET
                    apellido='".$apellido."',
                    nombre='".$nombre."',
                    alias='".$alias."',
                    genero='".$genero."',
                    lugar_nac=".$lugar_nacimiento.",
                    nacionalidad=".$nacionalidad.",
                    fecha_nac='".$fecha_nac."',
                    domicilio='".$domicilio."',
                    telefono='".$telefono."',
                    mail='".$mail."',
                    observacion='".$observacion."',
                    id_primaria=".$primaria.",
                    id_secundario=".$secundario.",
                    auto_medico=".$auto_medico.",
                    auto_salida=".$auto_salida."
                where dni=".$dni." and activo = 0;";
    $res = mysql_query($modificar);

    if (!($res)) {        
        $error = "Problemas para modificar los datos, compruebe que este todo ok.";
        /*echo "apellido='".$apellido."',
                    nombre='".$nombre."',
                    alias='".$alias."',
                    genero='".$genero."',
                    lugar_nac=".$lugar_nacimiento.",
                    nacionalidad=".$nacionalidad.",
                    fecha_nac='".$fecha_nac."',
                    domicilio='".$domicilio."',
                    telefono='".$telefono."',
                    mail='".$mail."',
                    observacion='".$observacion."',
                    id_primaria=".$primaria.",
                    id_secundario=".$secundario.",
                    auto_medico=".$auto_medico.",
                    auto_salida=".$auto_salida."
                where dni=".$dni.";";*/
    } else {
        $error = "Se realizaron los cambios correctamente.";
    }

//  cierra la conexion
$conn_obj->close();

}
?>
