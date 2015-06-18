<?php 

/*
Aporte del usuario iontxu de www.forosdelweb.com
link: http://www.forosdelweb.com/f18/aporte-funcion-que-redimensiona-imagenes-565428/

Funci—n REDIMENSIONAR 
Toma la ruta de una imagen, un valor m‡ximo de ancho y otro m‡ximo de alto.
Si la imagen rebasa dichas medidas, calcula las medidas m‡ximas que podr’a tener manteniendo el formato original para no salirse de las medidas indicadas. 
Finalmente la funci—n imprime la imagen. 
*/ 

function redimensionar($ruta,$ancho,$alto){ 

//Obtenemos las dimensiones, la ruta es absoluta. 

    $dim = getimagesize($ruta);
    /*getimagesize() pasa un array a la variable $dim tal que $dim[0] contiene el ancho de la imagen y dim[1] contiene el alto.*/ 

    if($dim[1]){ 
    //Para asegurarnos de que dim[1] es diferente de cero 
    $cociente = $dim[0] / $dim[1]; 
    } 

    if($alto){ 
    //Para asegurarnos de que alto es diferente de cero 
    $coc_max = $ancho / $alto; 
    } 

    if(($dim[0]<=$ancho)&&($dim[1]<=$alto)){ 
    /*En este caso no pasa nada y la imagen se imprime con su tama–o original*/ 
    $ancho = $dim[0]; 
    $alto = $dim[1]; 
    }else{ 
        if($cociente>=$coc_max){ 
        /*En este caso el factor m‡s restrictivo va a ser el ancho de la foto*/ 
        $alto = $ancho / $cociente; 
        }else{ 
        /*En este caso el factor restrictivo va a ser la altura de la foto*/ 
        $ancho = $alto * $cociente; 
        } 
    } 
    
    echo "<img src='$ruta' width='$ancho' height='$alto'>"; 
} 
?>