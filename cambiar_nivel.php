<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1
 */
/*Con include_once llamamos a la página de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");


?>

    <div>
        <form action="cambiar_nivel.php?id=<?php echo $usuario; ?>" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Datos</legend>
                <label for="nombre">Usuario: </label><input type="text" name="usuario" value="<?php echo @$nombre_usuario; ?>" disabled/><br/>
                <label for="nombre">Nombre: </label><input type="text" name="nombre" value="<?php echo @$nombre; ?>" disabled/><br/>
                <label for="nombre">Nivel: </label><input type="text" name="nivel" value="<?php echo @$nivel; ?>" /><br/>

                <input type="submit" value="Guardar" class="boton">
            </fieldset>
            <input type="hidden" name="cmd" value="nivel"/>
        </form>
        <p>El cambio en el nivel lo vera cuando vuelva a la tabla de usuarios.</p><br>
        <a href="usuarios.php" >Volver a los Usuarios</a>
    </div>
<br>
    <div>
		<table>
			<tr>
				<th></th>
				<th>Equipo Directivo</th>
				<th>Equipo Tecnico</th>
				<th>Equipo Pedagogico</th>
				<th>Depto. Alumnos</th>
				<th>Preceptores</th>
			</tr>
			<tr align="center">
				<td></td>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
			</tr>
			<tr align="center">
				<td>Buscar Alumno</td>
				<td>X</td>
				<td>X</td>
				<td>X</td>
				<td>X</td>
				<td>X</td>
			</tr>
			<tr align="center">
				<td>Agregar Alumno</td>
				<td>X</td>
				<td></td>
				<td></td>
				<td>X</td>
				<td></td>				
			</tr>
			<tr align="center">
				<td>Modificar Alumno</td>
				<td>X</td>
				<td></td>
				<td></td>
				<td>X</td>
				<td></td>
			</tr>			
			<tr align="center">
				<td>Cargar/Ver Intervencion</td>
				<td>X</td>
				<td>X</td>
				<td>X</td>
				<td></td>
				<td></td>
			</tr>			
			<tr align="center">
				<td>Cargar Novedades</td>
				<td>X</td>
				<td>X</td>
				<td>X</td>
				<td></td>
				<td></td>
			</tr>			
			<tr align="center">
				<td>Tomar Asistencia</td>
				<td>X</td>
				<td>X</td>
				<td>X</td>
				<td></td>
				<td>X</td>
			</tr>
		</table>
    </div>

<br><br>
  
<br>
<?php

include_once($APP_PATH . "/includes/footer.php");
?>
