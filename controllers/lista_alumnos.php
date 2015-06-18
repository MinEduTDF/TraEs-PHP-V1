<?php
/**
 * @author Victoria Marino
 * @package controllers
 * @version 2
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
$cmd_b = @$_POST["cmd"];
$ids = @$_POST['ids'];
$fec = $fecha ->form2sql(@$_POST["fecha"]);
$curso_alumno = @$_POST["curso"];
$division_alumno = @$_POST["division"];
$tipo_curso = @$_POST["tipo_curso"];
$lista_nueva = @$_POST["lista_nueva"];

if( $cmd_b == "confirmar" ) {
    //  abre la conexion
    $conn_obj->open();
    
    //Comprobar si se toma lista por primera vez o no y depende de eso inserto o actualizo.
    if (!$lista_nueva) {
	//Inserto en la tabla Lista_Cursos el registro.
        
		$insertar = "INSERT INTO `lista_cursos` (`fecha`, `tipo_curso`, `curso`, `division`, `usuario`, `fecha_carga`)
                VALUES('".$fec."','".$tipo_curso."',".$curso_alumno.",".$division_alumno.",'".$_SESSION["id_usuario"]."','".date(Ymd)."');";
		$sql_insertar = mysql_query($insertar);
        
		if (!$sql_insertar){
			
			$error = "Ocurrio un error al tomar lista para este curso por favor intente nuevamente o comuniquese con el Administrador del Sistema. Gracias! :)";
			echo $insertar;        

		} else {
		
        	if (sizeof($ids) > 0) {

            	foreach($ids as $id) {
                	$i=$i+1;
                	$confirmar = "INSERT INTO lista_alumnos (fecha, tipo_curso, dni, estado, curso, division, usuario, fecha_cambio) 
					VALUES('".$fec."',".$tipo_curso.",".$id.",'".@$_POST[$i]."',".$curso_alumno.",".$division_alumno.",'".$_SESSION["id_usuario"]."','".date(Ymd)."')";
                	$cantidad = mysql_query($confirmar);
            	}
            	if (!$cantidad){
                
                	$error = "No se pudo tomar lista, asegurese de que ya no esten confirmados.";
					echo $confirmar;

            	} else {
            		header("location:tomar_asistencia.php");
            		exit;
            	}
        	} else {
            
            	$error = "No selecciono ning&uacute;n alumno para confirmar, vuelva a intentarlo";
            
        	}
		}
	} else {
        if (sizeof($ids) > 0) {
            
        	foreach($ids as $id) {
                $i=$i+1;
                $confirmar = "UPDATE lista_alumnos 
                SET estado='".@$_POST[$i]."',
                usuario= '".$_SESSION["id_usuario"]."'
                WHERE dni = ".$id." AND tipo_curso = ".$tipo_curso." AND fecha = '".$fec."';";
			    $cantidad = mysql_query($confirmar);
            }
            if (!$cantidad){
                
				$error = "No se pudo tomar lista, asegurese de que ya no esten confirmados.";
				echo $confirmar;

            } else {
            	header("location:tomar_asistencia.php");
            	exit;
            }
            
        } else {
            
            $error = "No selecciono ning&uacute;n alumno para confirmar, vuelva a intentarlo";
            
        }        
    } 
//  cierra la conexion
$conn_obj->close();
}

?>
