<?php

$page_ar = explode("/",$_SERVER["SCRIPT_NAME"]);
$page = $page_ar[sizeof($page_ar)-1];
include_once($APP_PATH . "/includes/controllers.php");

?>

<!DOCTYPE html>
<html>
<head>
<title>TraEs - <?php echo $colegio; ?></title>
<link rel="shortcut icon" type="image/x-icon" href="imgs/favicon.png">
<link rel="stylesheet" type="text/css" href="css/global.css" />
<script type="text/javascript" src="js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.3.js"></script>
<script type="text/javascript">
jQuery(function($){
   $("#mascarafecha").mask("99/99/9999");
   $("#mascarafecha2").mask("99/99/9999");
});
</script>

</head>
<body>

<div>
    <ul id="nav">
        <li class="current"><a href="index.php">INICIO</a></li>
        <li><a href="buscar_alumno.php">ALUMNO</a>
        	<ul>
		        <li><a href="buscar_alumno.php">BUSCAR ALUMNO</a></li>
		        <li><a href="agregar_alumno.php">AGREGAR ALUMNO</a></li>
    		    <li><a href="modificar_alumno.php">MODIFICAR ALUMNO</a></li>
        	</ul>
        </li>
<!--        <li><a href="">CURSO</a>
			<ul>
		        <li><a href="novedad_curso.php">NOVEDADES CURSO</a></li>
		        <li><a href="datos_curso.php">DATOS CURSO</a></li>
		    </ul>
		</li>-->
        <li><a href="informe_asistencia.php">ASISTENCIA</a>
			<ul>
		        <li><a href="tomar_asistencia.php">TOMAR ASISTENCIA</a></li>
		        <li><a href="llegada_tarde.php">LLEGADAS TARDES</a></li>
		        <li><a href="informe_asistencia.php">INFORME ASISTENCIA</a></li>
		        <li><a href="modificar_asistencia.php">MODIFICAR ASISTENCIA</a></li>
		    </ul>
		</li>
        <li><a href="login.php?cmd=logoff">CERRAR</a></li>
    </ul>
</div>
<div class="contenido">
<!-- Esta p‡gina se utiliza para tener el mismo encabezado en todas las p‡ginas.-->
