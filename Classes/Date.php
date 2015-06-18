<?php
/**
 * @author Enrique Nicolas Colasurdo y Marino Victoria
 * @package Classes
 * @version 1.0
 */

class Date
{
    /**
     * Agregar un valor determinado a una fecha (
     * @param string $interval Valor que incrementa
     * @param int $number Valor a incrementa
     * @param string $date Fecha a modificar (d/m/Y [H:i:s])
     * @return string Fecha (d/m/Y [H:i:s])
     */
    function dateAdd($interval, $number, $date)
    {
        $arFechaT  = explode(" ",$date);
        $arFecha1  = explode("/",$arFechaT[0]);
        $arFecha2  = sizeof($arFechaT)==2 ? explode(":",$arFechaT[1]) : 0;

        $hora = sizeof($arFechaT)==2 && sizeof(@$arFecha2) == 3? $arFecha2[0] : 0;
        $minuto = sizeof($arFechaT)==2 && sizeof(@$arFecha2) == 3? $arFecha2[1] : 0;
        $segundo = sizeof($arFechaT)==2 && sizeof(@$arFecha2) == 3? $arFecha2[2] : 0;
        $dia = $arFecha1[0];
        $mes = $arFecha1[1];
        $ano = $arFecha1[2];
        $date = mktime($hora,$minuto,$segundo,$mes,$dia,$ano);
        $date_time_array = getdate($date);
        $hours = $date_time_array['hours'];
        $minutes = $date_time_array['minutes'];
        $seconds = $date_time_array['seconds'];
        $month = $date_time_array['mon'];
        $day = $date_time_array['mday'];
        $year = $date_time_array['year'];
    
        switch ($interval)
        {
            case 'yyyy':
                $year+=$number;
                break;
            case 'q':
                $year+=($number*3);
                break;
            case 'm':
                $month+=$number;
                break;
            case 'y':
            case 'd':
            case 'w':
                $day+=$number;
                break;
            case 'ww':
                $day+=($number*7);
                break;
            case 'h':
                $hours+=$number;
                break;
            case 'n':
                $minutes+=$number;
                break;
            case 's':
                $seconds+=$number;
                break;            
        }
        $timestamp= mktime($hours,$minutes,$seconds,$month,$day,$year);
        $return = sizeof(@$arFecha2) == 3 ? strftime('%d/%m/%Y %H:%M:%S',$timestamp) : strftime('%d/%m/%Y',$timestamp);

        return $return;
    }

    /**
     * Formatea la fecha de un formulario para pasar a SQL
     * @param string $date Fecha del Formulario
     * @return string Fecha (Ymd)
     */
    function form2sql($date)
    {
//	if($date=="") $date =  date_default_timezone_set("d/m/Y"); //Utilizar si se quiere que ponga la fecha del d’a si esta tagueado pone en 0 la fecha.
	$date = explode("/",$date);
	$date = $date[2].$date[1].$date[0];
	
	return $date;
    }

    /**
     * Formatea la fecha de un SQL para mostrar en un HTML
     * @param string $date Fecha SQL (yyyymmdd)
     * @return string Fecha (dd/mm/yyyy)
     */
    function sql2form($date)
    {
	$year = substr($date,0,4);
	$month = substr($date,5,2);
	$day = substr($date,8,2);
        $dateReturn = "$day/$month/$year";

	return $dateReturn;
    }
    /**
     * Formatea la fecha de un MySQL para consultar
     * @param string $date Fecha MySQL (yyyy-mm-dd)
     * @return string Fecha (yyyymmdd)
     */
    function Mysql2sql($date)
    {
	$year = substr($date,0,4);
	$month = substr($date,4,2);
	$day = substr($date,6,2);
        $dateReturn = "$year$month$day";

	return $dateReturn;
    }
}
?>
