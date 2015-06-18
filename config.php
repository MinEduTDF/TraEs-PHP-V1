<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1.2
 */
/*Con include_once llamamos a la página de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");
?>

<div>
    <h3>Estas logueado como: <?php echo $_SESSION["nombre"]; ?></h3>
</div>

    <div>
        <form action="config.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Datos</legend>
                <label for="nombre">Nombre: </label><input type="text" name="nombre" value="<?php echo @$nombre_datos; ?>" /><br/>
                <label for="mail">Mail: </label><input type="text" name="mail" value="<?php echo @$mail_datos; ?>" /><br/>
                <label for="cumpleanos">Cumplea&#241;os: </label><input type="text" name="fech_nac" value="<?php echo @$fecha_datos; ?>" id="mascarafecha"/><br/>
                <input type="submit" value="Guardar" class="boton">
            </fieldset>
            <input type="hidden" name="cmd2" value="datos"/>
        </form>
        <a href="#" onClick="location.reload(false);" >Recargar para ver los cambios</a>
    </div>

<br><br>

    <div>
        <form action="config.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Cambiar la contrase&#241;a</legend>
                <label for="contrasena_vieja">Contrase&#241;a Vieja: </label><input type="password" name="clave_vieja" /><br/>
                <label for="contrasena_nueva">Contrase&#241;a Nueva: </label><input type="password" name="clave_nueva" /><br/>
                <input type="submit" value="Cambiar" class="boton">
            </fieldset>
            <input type="hidden" name="cmd1" value="clave"/>
        </form>
    </div>

<br><br>
  
<br>
<?php
echo @$error;

include_once($APP_PATH . "/includes/footer.php");
?>
