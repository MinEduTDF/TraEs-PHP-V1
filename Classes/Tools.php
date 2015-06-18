<?php
/**
 * @author Enrique Nicolas Colasurdo
 * @package Classes
 * @version 1.0
 */

class Tools
{
    /**
     * Busca el index de un valor en un Array
     * @param string $value Valor a encontrar
     * @param mixed $array Array donde buscar
     * @return integer
     */
    function find_array_index($value,$array)
    {
        $num = "";
        for($i=0;$i<sizeOf($array);$i++)
        {
            if($array[$i]==$value)
            {
                $num = $i;
            }
        }
        return $num;
    }

    /**
     * in_array() multidimensional
     * @needle mixed Valor a encontrar
     * @param array $array Array donde buscar
     * @return bool
     */
    function in_multi_array($needle, $haystack)
    {
	$in_multi_array = false;
	if(in_array($needle, $haystack))
	{
	    $in_multi_array = true;
	}
	else
	{   
	    for($i = 0; $i < sizeof($haystack); $i++)
	    {
		if(is_array($haystack[$i]))
		{
		    if(in_multi_array($needle, $haystack[$i]))
		    {
			$in_multi_array = true;
			break;
		    }
		}
	    }
	}
	return $in_multi_array;
    } 

    /**
     * Llena con ceros a la izquierda
     * @param string $value Valor a llenar
     * @param integer $length Cantidad de caracteres nuevos
     * @return integer 
     */
    function zero_fill($value,$length)
    {
        $zero_fill = $value;
        $len = strlen($value);
        for($i=$len;$i<$length;$i++)
        {
            $zero_fill = "0".$zero_fill;
        }
        return $zero_fill;
    }

    /**
     * Limpia cualquier caracter y reemplaza los caracteres extra&ntilde;os
     * @param string $value Valor a limpiar
     * @return string 
     */
    function safe_string($value)
    {
        $value = get_magic_quotes_gpc() ? stripcslashes($value) : $value;
		$value = addslashes($value);
		$value = str_replace("INSERT ","",$value);
		$value = str_replace("DELETE ","",$value);
		$value = str_replace("UPDATE ","",$value);
		$value = str_replace("TRUNCATE ","",$value);
		$value = str_replace("CREATE ","",$value);
		$value = str_replace("DROP ","",$value);
		$value = str_replace("ALTER ","",$value);
		$value = str_replace("EXECUTE ","",$value);
		$value = str_replace("'","",$value);
		$value = utf8_decode($value);
		//$value = preg_replace("/[<>=¡*^¨|$%&¿-_,.;:]/", "", $value);
		return $value;
    }

    /**
     * Limpia barras
     * @param string $value Valor a limpiar
     * @return string 
     */
    function safe_read_string($value)
    {
        $value = get_magic_quotes_gpc() ? stripcslashes($value) : $value;
		$value = utf8_encode($value);
		$value = stripslashes($value);
		$value = str_replace("\"","'",$value);

		//	se le eliminan los tabs y lineas por error con objeto de tablas
		$value = str_replace("\t","  ",$value);
		$value = str_replace("\n","  ",$value);

		return $value;
    }

}
?>