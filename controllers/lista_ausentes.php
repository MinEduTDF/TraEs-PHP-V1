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

//Traigo los datos con el metdo POST para que no se vean en la barra URL
$cmd_b = @$_POST["cmd"];
$ids = @$_POST['ids'];
$fec = $fecha ->form2sql(@$_POST["fecha"]);

if( $cmd_b == "confirmar" ) {
    //  abre la conexion
    $conn_obj->open();

//Actualizo la tabla lista_alumnos con las llegadas tardes.
        
    if (sizeof($ids) > 0) {
        
        foreach($ids as $id) {
            $i=$i+1;
            if (@$_POST[$i] == "A" || @$_POST[$i] == "TC" || @$_POST[$i] == "TM" || @$_POST[$i] == "AP") {
                if (@$_POST["j".$i] == true ? @$_POST["j".$i] : @$_POST["j".$i] =0);

                $confirmar = "CALL llegada_tarde(".$id.",'".@$_POST[$i]."',".@$_POST["j".$i].",'".@$_POST["o".$i]."','".$_SESSION["id_usuario"]."')";
                $cantidad = mysql_query($confirmar);
            }
        }
        if (!$cantidad){
            
            $error = "No se pudo tomar lista, asegurese de que ya no esten confirmados.";
            
        } else {
            
        header("location:llegada_tarde.php");
        
        exit;
        }
        
    } else {
        
        $error = "No selecciono ning&uacute;n alumno para confirmar, vuelva a intentarlo";
        
    }

//  cierra la conexion
$conn_obj->close();

}

?>
