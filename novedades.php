<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1.2
 */
/*Con include_once llamamos a la p‡gina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");

if($_SESSION["nivel"]==1 || $_SESSION["nivel"]==2 || $_SESSION["nivel"]==3){
?>

<form action="novedades.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Nueva Novedad</legend>
        <label for="titulo">T&iacute;tulo: </label><input type="text" name="titulo" /><br>
        <label for="texto">Descripci&oacute;n: </label>
        <textarea rows="4" cols="25" name="texto">
        </textarea><br>
        <label for="fecha_desde">Fecha Desde: </label><input type="text" name="fecha_desde" id="mascarafecha"/><br/>
        <label for="fecha_hasta">Fecha Hasta: </label><input type="text" name="fecha_hasta" id="mascarafecha2"/><br/>
        <input type="submit" value="Ingresar" class="boton">
    </fieldset>
    <input type="hidden" name="cmd" value="novedad"/>
</form>

<?php
} else {
    echo "No tiene autorizaci&oacute;n para enviar Novedades";
}
include_once($APP_PATH . "/includes/footer.php");
?>
