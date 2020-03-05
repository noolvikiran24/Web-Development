<?php 
$con = mysqli_connect("localhost", "root", "root", "clothingstore");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING );  

if(mysqli_connect_errno()){
	echo "Databse connection error: ".mysqli_connect_error();
	die();
}

require_once $_SERVER['DOCUMENT_ROOT'].'/Clothing Store/config.php';
require_once BASEURL.'/helpers/helpers.php';

$cart_id = '';
if(isset($_COOKIE['CART_COOKIE'])){
	$cart_id = sanitize($_COOKIE['CART_COOKIE']);
}

 ?> 