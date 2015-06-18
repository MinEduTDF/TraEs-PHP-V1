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

//Traigo los datos con el mŽtdo POST para que no se vean en la barra URL
$nombre = @$_POST["nombre"];
$apellido = @$_POST["apellido"];
$alias = @$_POST["alias"];
$dni = @$_POST["dni"];
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
$activo = @$_POST["activo"];
$archivo = @$_FILES["foto"]['tmp_name'];
$archivo_name = @$_FILES["foto"]['name'];
$cmd = @$_POST["cmd"];
$punto = ".";

if( $cmd == "carga" ) {
    if ($dni == "" || stripos($dni, $punto) == TRUE) {
        $alerta = "<font color='red'>El <strong>n&uacute;mero de DNI</strong> del Alumno es un dato <strong>obligatorio</strong> y no debe llevar puntos ni rayas ni espacios. </font><br><br>";
    } else {

/*echo $nombre."','".$apellido."','".$alias."',".$dni.",".$lugar_nacimiento.",".$nacionalidad.",'".$fecha_nac."','".$domicilio."','".$telefono."','".$mail."','".$genero."','".$observacion."','".$ruta."',".$activo.",".$primaria.",".$secundario.",".$auto_medico.",".$auto_salida;*/

    //  abre la conexion
    $conn_obj->open();

    //Cargo la imagen de la foto
    if (is_uploaded_file($archivo) ) {
        //Obtengo el nombre de la imagen y la extensi—n de la foto
        $imagen = explode(".",$archivo_name);
        //Le pongo el nombre a la imagen del dni y la extension obtenida anteriormente
        $imagen1 = $dni.".".$imagen[1];
        $ruta="fotos/".$imagen1;        
    } else {
        $ruta="fotos/foto.png";
        $error = "No se pudo cargar la foto";
    }
    
    //Llamo el SP para agregar un alumno que tengo en la BD

    @$sql = "CALL agregar_alumno('".$nombre."','".$apellido."','".$alias."',".$dni.",".$lugar_nacimiento.",".$nacionalidad.",'".$fecha_nac."','".$domicilio."','".$telefono."','".$mail."','".$genero."','".$observacion."','".$ruta."',".$activo.",".$primaria.",".$secundario.",".$auto_medico.",".$auto_salida.");";
    $res = mysql_query($sql);
    $rs = mysql_fetch_assoc($res);
    
    if ($rs["estado"] == "nuevo") {
        
        //Coloco la imagen del usuario en la carpeta correspondiente con el nuevo nombre
        if (is_uploaded_file($archivo) ) {
            move_uploaded_file($archivo, "fotos/".$imagen1);
            $error = "Se guardo la foto sin problema";
        } else {
            $error = "No se pudo guardar la foto";
        }
        $cargado = "Se agrego un alumno nuevo: DNI ".$rs["dni"].", ".$rs["nombre_alumno"]." ".$rs["apellido"];
        
    } elseif ($rs["estado"] == "cargado") {
        $cargado = "El DNI ".$rs["dni"]." ya se encuentra registrado para el alumno ".$rs["nombre_alumno"]." ".$rs["apellido"];
    }

    //  cierra la conexion
    $conn_obj->close();
    }
}
?>
