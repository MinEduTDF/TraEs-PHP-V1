<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1.2
 */
/*Con include_once llamamos a la p‡gina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");

$page_ar = explode("/",$_SERVER["SCRIPT_NAME"]);
$page = $page_ar[sizeof($page_ar)-1];
include_once($APP_PATH . "/includes/controllers.php");

?>

<!DOCTYPE html>
<html>
<head>
<title>TraEs - Prometeo</title>
<link rel="shortcut icon" type="image/x-icon" href="imgs/favicon.png">
<link rel="stylesheet" type="text/css" href="css/global.css" />
</head>
<body>
    <div class="contenido">
<!--Formulario para el login del usuario -->

    <form action="login.php" method="post">
        <fieldset>
            <legend>Ingrese sus datos</legend>
            <label for="usuario">Usuario: </label><input type="text" name="usuario" /><br/>
            <label for="clave">Clave: </label><input type="password" name="clave" /><br/>
            <input type="submit" value="Ingresar">
        </fieldset>
        <input type="hidden" name="cmd" value="login"/>
    </form>
<br>
<br>

<?php
echo @$msg;
include_once($APP_PATH . "/includes/footer.php");
?>