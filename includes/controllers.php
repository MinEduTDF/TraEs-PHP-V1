<?php



//  include common controller

include_once($APP_PATH . "/controllers/common.php");


//  include page controller if exist

if( is_file($APP_PATH . "/controllers/" . $page) ) include_once($APP_PATH . "/controllers/" . $page );


?>