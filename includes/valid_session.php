<?php
/*Inicia la sesion*/

@ob_start();
@session_start();

/*Consulta si el usuario esta logueado en una sesion o no*/

if( !isset($_SESSION["id_usuario"]) || round($_SESSION["id_usuario"]) <= 0)
    {
/*si el usuario no esta logueado entonces lo direcciona a la pagina de login*/    
        header("location:login.php"); 
        exit;
    }

?>