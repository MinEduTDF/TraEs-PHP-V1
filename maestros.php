<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1.0
 */
/*Con include_once llamamos a la página de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/includes/header.php");

if($_SESSION["nivel"]==9){
?>
	<div>
		<ul>
			<li>
		        <a href="usuarios.php">
		            <img src="imgs/modificar.png" alt="Usuarios"/> Usuarios
		        </a>
			</li>
			<li>
		        <a href="tipocurso.php">
		            <img src="imgs/modificar.png" alt="Tipo de curso"/> Tipo de Curso
		        </a>
			</li>
			<li>
		        <a href="cursos.php">
		            <img src="imgs/modificar.png" alt="Cursos"/> Cursos
		        </a>
			</li>
			<li>
		        <a href="divisiones.php">
		            <img src="imgs/modificar.png" alt="Divisiones"/> Divisiones
		        </a>
			</li>
			<li>			
		        <a href="nacionalidad.php">
		            <img src="imgs/modificar.png" alt="Nacionalidad"/> Nacionalidad
		        </a>
			</li>
			<li>
		        <a href="lugar_nacimiento.php">
		            <img src="imgs/modificar.png" alt="Lugar Nacimiento"/> Lugar de Nacimiento
		        </a>
			</li>
			<li>
		        <a href="primarias.php">
		            <img src="imgs/modificar.png" alt="Primarias"/> Escuelas Primarias
		        </a>
			</li>
			<li>
		        <a href="secundarios.php">
		            <img src="imgs/modificar.png" alt="Secundarios"/> Colegios Secundarios
		        </a>
			</li>
		</ul>
    </div>

<?php
} else {
    echo "No tiene autorizaci&oacute;n para realizar cambios de Configuraci&oacute;n";
}
include_once($APP_PATH . "/includes/footer.php");
?>
