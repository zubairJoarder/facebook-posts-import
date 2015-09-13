<?php

define('INCLUDE_PATH', dirname(__FILE__).'/'); 
define('DATA_MODE' , 'FILE_READ');
define('DATA_SOURCE' , INCLUDE_PATH . 'sample-data\facebook-data.json');
include_once INCLUDE_PATH . 'php\WordpressPoster.php';
date_default_timezone_set("Australia/Sydney"); 
?>