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

//  instancia los objetos
$conn_obj = new Connection();


//Traigo los datos con el mŽtdo POST para que no se vean en la barra URL
$dni_alumno = @$_POST["dni_alumno"];


// Datos para agregar una nueva foto
$archivo = @$_FILES["foto"]['tmp_name'];
$archivo_name = @$_FILES["foto"]['name'];
$archivo_tipo = @$_FILES["foto"]['type'];
$cmd2 = @$_POST["cmd2"];


if( $cmd2 == "carga_foto" ) {

    if ($dni_alumno == "") {
        $error = "NO SE GUARDO LA IMAGEN. <br><br>Intentelo nuevamente";
    } else {
        
        //  abre la conexion
        $conn_obj->open();
        
        if (is_uploaded_file($archivo) ) {
            //recojo la imagen
            $imagen = $archivo_name;
            
            //Obtengo el nombre de la imagen y la extensi—n de la foto
            $imagen1 = explode(".",$imagen);
            
            //Genero el nombre con el DNI y la extensi—n obtenido anteriormente
            $imagen2 = $dni_alumno.".".$imagen1[1];
            
            //Coloco la iamgen del usuario en la carpeta correspondiente con el nuevo nombre
            move_uploaded_file($archivo, "fotos/".$imagen2);
            $ruta="fotos/".$imagen2;
            
            //Guardo la ruta donde se guarda la imagen en el registro del alumno
            $sql = "UPDATE `alumnos` SET foto='".$ruta."' WHERE dni=".$dni_alumno.";";
            $res = mysql_query($sql);
            
            $error = "Tu nueva imagen ha sido subida";
            if (!$res) {
                echo "Error al ejecutar la consulta (".$sql.")\n";
            }
        } else {
            $error = "No se pudo guardar la foto";
        }
        //  cierra la conexion
        $conn_obj->close();
    }
}

?>
