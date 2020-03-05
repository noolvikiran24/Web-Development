<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
session_start();
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/Clothing Store');

define('CART_COOKIE', 'KNKEK3mcmeiKDF234');
define("CART_COOKIE_EXPIRE", time()+(86400*30));
//echo BASEURL;

?>