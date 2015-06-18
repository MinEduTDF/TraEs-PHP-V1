<?php
/**
 * @author Victoria Marino
 * @package Index
 * @version 1.2
 */
/*Con include_once llamamos a la p‡gina de referencia y la mostramos*/
include_once(dirname(__FILE__) . "/includes/common.php");
include_once($APP_PATH . "/includes/valid_session.php"); 
include_once($APP_PATH . "/controllers/common.php"); 

$page_ar = explode("/",$_SERVER["SCRIPT_NAME"]);
$page = $page_ar[sizeof($page_ar)-1];
include_once($APP_PATH . "/includes/controllers.php");

?>

<!DOCTYPE html>
<html>
<head>
<title>TraEs - <?php echo $colegio; ?> </title>
<link rel="shortcut icon" type="image/x-icon" href="imgs/favicon.png">
<link rel="stylesheet" type="text/css" href="css/global.css" />
</head>

<body>
    <div class="contenido">

    <div>
	<h2><?php echo $colegio; ?></h2>
        <h1>Bienvenido/a
        <?php echo $_SESSION["nombre"]; ?>
        </h1>
    </div> <!--Título-->
    <div id="accesos">
        <ul>
            <li>
                <a href="config.php">
                    <img src="imgs/botonconfig.png" alt="Configuracion Usuario" border="0"/>
                </a>
            </li>            
        <?php if($_SESSION["nivel"]==1 || $_SESSION["nivel"]==2 || $_SESSION["nivel"]==3){
            print "<li>";
                print "<a href='novedades.php'>";
                    print "<img src='imgs/listas.png' alt='Informar Novedades' border='0'/>";
                print "</a>";
            print "</li>";
        }
        ?>
        <?php if($_SESSION["nivel"]==9){
            print "<li>";
                print "<a href='maestros.php'>";
                    print "<img src='imgs/listas.png' alt='Configuracion Maestros' border='0'/>";
                print "</a>";
            print "</li>";
        }
        ?>
        <?php if($_SESSION["nivel"]==1 || $_SESSION["nivel"]==2 || $_SESSION["nivel"]==3 || $_SESSION["nivel"]==5){
            print "<li>";
                print "<a href='tomar_asistencia.php'>";
                    print "<img src='imgs/lista.png' alt='Tomar Asistencia' border='0'/>";
                print "</a>";
            print "</li>";
        }
        ?>
            <li>
                <a href="buscar_alumno.php">
                    <img src="imgs/5.png" alt="Buscar alumno" border="0"/>
                </a>
            </li>

        </ul>
    </div> <!--Accesos Directos-->
    <br class="clear"/>
    <div id="novedades">
        <h3>Novedades</h3>
<!--        <a href="informe_inasistencias.php">Ver partes de inasistencias</a> Informes solicitados por los Andes -->
        <p><?php echo @$novedades; ?></p>
    </div> <!--Novedades-->
    <br>
    <div id="cumpleanos">
        <h3>Cumplea&#241;os</h3>
        <p><?php echo @$cumple; ?></p>
        <p><?php echo @$cumple_usu; ?></p>
    </div> <!--Cumpleaños-->


    

<?php
include_once($APP_PATH . "/includes/footer.php");
?>
